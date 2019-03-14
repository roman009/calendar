<?php

namespace App\Application\Services\Calendar\Fetch\Microsoft;

use App\Application\Services\Calendar\Fetch\AbstractFetchAdapter;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\Event;
use App\Entity\ExchangeAuthToken;
use App\Entity\ExchangeCalendar;
use App\Entity\FreeBusy;
use App\Repository\ExchangeAuthTokenRepository;
use App\Repository\ExchangeCalendarRepository;
use jamesiarmes\PhpEws\ArrayType\ArrayOfMailboxData;
use jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfBaseFolderIdsType;
use jamesiarmes\PhpEws\Client;
use jamesiarmes\PhpEws\Enumeration\ContainmentComparisonType;
use jamesiarmes\PhpEws\Enumeration\ContainmentModeType;
use jamesiarmes\PhpEws\Enumeration\DefaultShapeNamesType;
use jamesiarmes\PhpEws\Enumeration\DistinguishedFolderIdNameType;
use jamesiarmes\PhpEws\Enumeration\FolderQueryTraversalType;
use jamesiarmes\PhpEws\Enumeration\FreeBusyViewType;
use jamesiarmes\PhpEws\Enumeration\ResponseClassType;
use jamesiarmes\PhpEws\Enumeration\UnindexedFieldURIType;
use jamesiarmes\PhpEws\Request\FindFolderType;
use jamesiarmes\PhpEws\Request\FindItemType;
use jamesiarmes\PhpEws\Request\GetUserAvailabilityRequestType;
use jamesiarmes\PhpEws\Type\CalendarViewType;
use jamesiarmes\PhpEws\Type\ConstantValueType;
use jamesiarmes\PhpEws\Type\DistinguishedFolderIdType;
use jamesiarmes\PhpEws\Type\Duration;
use jamesiarmes\PhpEws\Type\EmailAddressType;
use jamesiarmes\PhpEws\Type\FolderResponseShapeType;
use jamesiarmes\PhpEws\Type\FreeBusyViewOptionsType;
use jamesiarmes\PhpEws\Type\ItemResponseShapeType;
use jamesiarmes\PhpEws\Type\MailboxData;
use jamesiarmes\PhpEws\Type\PathToUnindexedFieldType;
use jamesiarmes\PhpEws\Type\RestrictionType;

class ExchangeAdapter extends AbstractFetchAdapter
{
    public const ALIAS = 'exchange';
    /**
     * @var ExchangeCalendarRepository
     */
    private $exchangeCalendarRepository;

    public function __construct(ExchangeCalendarRepository $exchangeCalendarRepository)
    {
        $this->exchangeCalendarRepository = $exchangeCalendarRepository;
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    /**
     * @param AuthToken $token
     *
     * @return array<Calendar>
     */
    public function calendars(AuthToken $token): array
    {
        $calendars = [];

        /** @var ExchangeAuthToken $token */
        $client = new Client($token->getServer(), $token->getUsername(), $token->getPassword(), $token->getVersion());

        // Build the request.
        $request = new FindFolderType();
        $request->FolderShape = new FolderResponseShapeType();
        $request->FolderShape->BaseShape = DefaultShapeNamesType::ALL_PROPERTIES;
        $request->ParentFolderIds = new NonEmptyArrayOfBaseFolderIdsType();
        $request->Restriction = new RestrictionType();

        // Search recursively.
        $request->Traversal = FolderQueryTraversalType::DEEP;

        // Search within the root folder. Combined with the traversal set above, this
        // should search through all folders in the user's mailbox.
        $parent = new DistinguishedFolderIdType();
//        $parent->Id = DistinguishedFolderIdNameType::CALENDAR;
        $parent->Id = DistinguishedFolderIdNameType::ROOT;
        $request->ParentFolderIds->DistinguishedFolderId[] = $parent;

        $response = $client->FindFolder($request);

        // Iterate over the results, printing any error messages or folder names and ids.
        $response_messages = $response->ResponseMessages->FindFolderResponseMessage;
        foreach ($response_messages as $response_message) {
            // Make sure the request succeeded.
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                $code = $response_message->ResponseCode;
                $message = $response_message->MessageText;
                throw new \Exception($message, $code);
            }
            // The folders could be of any type, so combine all of them into a single
            // array to iterate over them.

//            $folders = array_merge(
//                $response_message->RootFolder->Folders->CalendarFolder,
//                $response_message->RootFolder->Folders->ContactsFolder,
//                $response_message->RootFolder->Folders->Folder,
//                $response_message->RootFolder->Folders->SearchFolder,
//                $response_message->RootFolder->Folders->TasksFolder
//            );

            $folders = $response_message->RootFolder->Folders->CalendarFolder;

            // Iterate over the found folders.
            foreach ($folders as $folder) {
                $exchangeCalendar = $this->exchangeCalendarRepository->findOneBy(['accountUser' => $token->getAccountUser(), 'calendarId' => $folder->FolderId->Id]);
                if (null === $exchangeCalendar) {
                    $exchangeCalendar = new ExchangeCalendar;
                }
                $isPrimary = $folder->FolderClass === 'IPF.Appointment' && $folder->ChildFolderCount !== 0;
                $exchangeCalendar
                    ->setChangeKey($folder->FolderId->ChangeKey)
                    ->setAccountUser($token->getAccountUser())
                    ->setCalendarId($folder->FolderId->Id)
                    ->setSummary($folder->DisplayName)
                    ->setPrimary($isPrimary);

                $this->exchangeCalendarRepository->persistAndFlush($exchangeCalendar);

                $calendars[] = $exchangeCalendar;
            }
        }

        return $calendars;
    }

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param array $calendars
     * @param string|null $timezone
     *
     * @return array<FreeBusy>
     * @throws \Exception
     */
    public function freeBusy(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        /** @var ExchangeAuthToken $token */
        $client = new Client($token->getServer(), $token->getUsername(), $token->getPassword(), $token->getVersion());

        $freeBusyList = [];

        $client->setTimezone($timezone);

        // Build the request.
        $request = new GetUserAvailabilityRequestType();
        $request->FreeBusyViewOptions = new FreeBusyViewOptionsType();
        $request->MailboxDataArray = new ArrayOfMailboxData();
// Define the time window and details to return.
        $request->FreeBusyViewOptions->TimeWindow = new Duration();
        $request->FreeBusyViewOptions->TimeWindow->StartTime = $startDate->format('c');
        $request->FreeBusyViewOptions->TimeWindow->EndTime = $endDate->format('c');
        $request->FreeBusyViewOptions->MergedFreeBusyIntervalInMinutes = 30;
        $request->FreeBusyViewOptions->RequestedView = FreeBusyViewType::DETAILED;
// Add the user to get availability for.
        $mailbox = new MailboxData();
        $mailbox->Email = new EmailAddressType();
        $mailbox->Email->Address = $token->getUsername();
        $mailbox->Email->RoutingType = 'SMTP';
        $mailbox->AttendeeType = 'Required';
        $mailbox->ExcludeConflicts = false;
        $request->MailboxDataArray->MailboxData[] = $mailbox;
        $response = $client->GetUserAvailability($request);
// Iterate over the user availability returned, printing any error messages or
// the working periods for each. On response will be included for each mailbox
// in the request.
        foreach ($response->FreeBusyResponseArray->FreeBusyResponse as $availability) {
            dump($availability);
            // Make sure the request succeeded.
            $response_message = $availability->ResponseMessage;
            if ($response_message->ResponseClass != ResponseClassType::SUCCESS) {
                $code = $response_message->ResponseCode;
                $message = $response_message->MessageText;
                dump("Failed to get user availability with \"$code: $message\"\n");
                continue;
            }
            // Iterate over the working periods for the user, printing the details of
            // each.
            $periods = $availability->FreeBusyView->WorkingHours->WorkingPeriodArray;
            foreach ($periods->WorkingPeriod as $period) {
                $start_minutes = $period->StartTimeInMinutes;
                $end_minutes = $period->EndTimeInMinutes;
                $start_time = new \DateTime("today $start_minutes minutes");
                $end_time = new \DateTime("today $end_minutes minutes");
                $output = $period->DayOfWeek . ' ' . $start_time->format('H:i') . ' - '
                    . $end_time->format('H:i') . "\n";
                dump($output);
                dump($period);
            }
        }

        die();

        return $freeBusyList;
    }

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $calendarId
     * @param string|null $timezone
     *
     * @return array<Event>
     */
    public function events(AuthToken $token, \DateTime $startDate, \DateTime $endDate, string $calendarId, string $timezone = null): array
    {
        // TODO: Implement events() method.
    }
}