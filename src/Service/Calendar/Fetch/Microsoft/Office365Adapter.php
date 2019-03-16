<?php

namespace App\Service\Calendar\Fetch\Microsoft;

use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Calendar;
use App\Entity\Calendar\Event;
use App\Entity\Calendar\FreeBusy;
use App\Entity\Calendar\Office365\Office365Calendar;
use App\Entity\Calendar\Office365\Office365Event;
use App\Entity\Calendar\Office365\Office365FreeBusy;
use App\Entity\Calendar\Outlook\OutlookCalendar;
use App\Repository\Calendar\Office365\Office365CalendarRepository;
use App\Service\Calendar\Fetch\AbstractFetchAdapter;
use App\Service\Calendar\Fetch\Microsoft\Model\GraphCalendar;
use GuzzleHttp\Exception\RequestException;
use Microsoft\Graph\Graph;

class Office365Adapter extends AbstractFetchAdapter
{
    public const ALIAS = 'office365';
    /**
     * @var Graph
     */
    private $client;
    /**
     * @var Office365CalendarRepository
     */
    private $office365CalendarRepository;

    public function __construct(Graph $client, Office365CalendarRepository $office365CalendarRepository)
    {
        $this->client = $client;
        $this->office365CalendarRepository = $office365CalendarRepository;
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    /**
     * @param AuthToken $token
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Microsoft\Graph\Exception\GraphException
     *
     * @return array<Calendar>
     */
    public function calendars(AuthToken $token): array
    {
        $this->client->setAccessToken($token->getAccessToken());

        $calendars = [];

        try {
            $calendarsResponse = $this->client->createRequest('GET', '/me/calendars')
                ->setReturnType(\Microsoft\Graph\Model\Calendar::class)
                ->execute();
        } catch (RequestException $exception) {
            throw new \Exception((string)$exception->getResponse()->getBody());
        }

        /** @var \Microsoft\Graph\Model\Calendar $calendar */
        foreach ($calendarsResponse as $calendar) {
            $office365Calendar = $this->office365CalendarRepository->findOneBy(['accountUser' => $token->getAccountUser(), 'calendarId' => $calendar->getId()]);
            if (null === $office365Calendar) {
                $office365Calendar = new Office365Calendar;
            }
            $office365Calendar
                ->setOwnerEmailAddress($calendar->getOwner()->getAddress())
//                ->setDescription()
                ->setSummary($calendar->getName())
//                ->setTimezone($calendar->get)
                ->setPrimary($calendar->getCanEdit())
                ->setCalendarId($calendar->getId())
                ->setAccountUser($token->getAccountUser());
            $this->office365CalendarRepository->persistAndFlush($office365Calendar);

            $calendars[] = $office365Calendar;
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
     * @throws \Exception
     *
     * @return array<FreeBusy>
     */
    public function freeBusy(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        $this->client->setAccessToken($token->getAccessToken());
        $this->client->setApiVersion('beta');

        $freeBusyList = [];

        $requestBody = [
            'Schedules' => array_unique(array_map(function (OutlookCalendar $calendar) {
                return $calendar->getOwnerEmailAddress();
            }, $calendars)),
            'StartTime' => [
                'dateTime' => $startDate->format(DATE_ATOM),
                'timeZone' => $timezone
            ],
            'EndTime' => [
                'dateTime' => $endDate->format(DATE_ATOM),
                'timeZone' => $timezone
            ],
            'availabilityViewInterval' => '15'
        ];

        $freeBusyResponse = $this->client->createRequest('POST', '/me/calendar/getschedule')
            ->attachBody($requestBody)
            ->setReturnType(GraphCalendar::class)
            ->execute();

        /** @var GraphCalendar $calendar */
        foreach ($freeBusyResponse as $calendar) {
            foreach ($calendar->getScheduleItems() as $busyTimePeriod) {
                $freeBusy = (new Office365FreeBusy)
                    ->setCalendar($calendar->getScheduleId())
                    ->setStart(new \DateTime($busyTimePeriod['start']['dateTime']))
                    ->setEnd(new \DateTime($busyTimePeriod['end']['dateTime']))
                    ->setType($busyTimePeriod['status'] === 'busy' ? FreeBusy::TYPE_BUSY : FreeBusy::TYPE_FREE);
                $freeBusyList[] = $freeBusy;
            }
        }

        return $freeBusyList;
    }

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $calendarId
     * @param string|null $timezone
     *
     * @throws \Microsoft\Graph\Exception\GraphException
     *
     * @return array<Event>
     */
    public function events(AuthToken $token, \DateTime $startDate, \DateTime $endDate, string $calendarId, string $timezone = null): array
    {
        $this->client->setAccessToken($token->getAccessToken());

        $calendar = $this->office365CalendarRepository->findOneBy(['accountUser' => $token->getAccountUser(), 'objectId' => $calendarId]);

        $eventList = [];

        $eventListResponse = $this->client->createRequest('GET', '/me/calendars/' . $calendar->getCalendarId() . '/events')
            ->setReturnType(\Microsoft\Graph\Model\Event::class)
            ->execute();

        /** @var \Microsoft\Graph\Model\Event $item */
        foreach ($eventListResponse as $item) {
            $office365Event = (new Office365Event)
                ->setName($item->getSubject())
                ->setStart(new \DateTime($item->getStart()->getDateTime(), new \DateTimeZone($item->getStart()->getTimeZone())))
                ->setEnd(new \DateTime($item->getEnd()->getDateTime(), new \DateTimeZone($item->getEnd()->getTimeZone())))
                ->setTimezone($item->getStart()->getTimeZone())
                ->setEventId($item->getId());
            $eventList[] = $office365Event;
        }

        return $eventList;
    }
}
