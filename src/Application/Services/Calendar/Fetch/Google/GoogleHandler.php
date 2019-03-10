<?php

namespace App\Application\Services\Calendar\Fetch\Google;

use App\Application\Services\Calendar\Fetch\AbstractFetchHandler;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\FreeBusy;
use App\Entity\GoogleCalendar;
use App\Entity\GoogleFreeBusy;
use App\Repository\GoogleCalendarRepository;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;
use Google_Service_Calendar_FreeBusyCalendar;
use Google_Service_Calendar_FreeBusyRequest;
use Google_Service_Calendar_FreeBusyRequestItem;
use Google_Service_Calendar_TimePeriod;

class GoogleHandler extends AbstractFetchHandler
{
    public const ALIAS = 'google';
    /**
     * @var \Google_Client
     */
    private $client;
    /**
     * @var GoogleCalendarRepository
     */
    private $googleCalendarRepository;

    public function __construct(\Google_Client $client, GoogleCalendarRepository $googleCalendarRepository)
    {
        $this->client = $client;
        $this->googleCalendarRepository = $googleCalendarRepository;
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    /**
     * @param AuthToken $token
     *
     * @return array<GoogleCalendar>
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function calendars(AuthToken $token): array
    {
        $this->client->setAccessToken($token->getAccessToken());

        $service = new Google_Service_Calendar($this->client);
        $calendars = [];

        /** @var Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($service->calendarList->listCalendarList() as $calendar) {
            $googleCalendar = $this->googleCalendarRepository->findOneBy(['user' => $token->getUser(), 'calendarId' => $calendar->getId()]);
            if (null === $googleCalendar) {
                $googleCalendar = new GoogleCalendar;
            }
            $googleCalendar
                ->setDescription($calendar->getDescription())
                ->setSummary($calendar->getSummaryOverride() ?? $calendar->getSummary())
                ->setTimezone($calendar->getTimeZone())
                ->setPrimary($calendar->getPrimary() ?? false)
                ->setCalendarId($calendar->getId())
                ->setUser($token->getUser());
            $this->googleCalendarRepository->persistAndFlush($googleCalendar);

            $calendars[] = $googleCalendar;
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
     * @return array<GoogleFreeBusy>
     */
    public function freeBusy(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        $this->client->setAccessToken($token->getAccessToken());

        $service = new Google_Service_Calendar($this->client);

        $freeBusyList = [];

        $postBody = new Google_Service_Calendar_FreeBusyRequest();
        $postBody->setItems(array_map(function (Calendar $calendar) {
            $item = new Google_Service_Calendar_FreeBusyRequestItem;
            $item->setId($calendar->getCalendarId());
            return $item;
        }, $calendars));
        $postBody->setTimeZone($timezone);
        $postBody->setTimeMin($startDate->format(DATE_ATOM));
        $postBody->setTimeMax($endDate->format(DATE_ATOM));
        try {
            $freeBusyResponse = $service->freebusy->query($postBody);
        } catch (\Google_Exception $exception) {
            $exception = json_decode($exception->getMessage(), true);
            throw new \Exception($exception['error']['message']);
        }

        /** @var Google_Service_Calendar_FreeBusyCalendar $freeBusyCalendar */
        foreach ($freeBusyResponse->getCalendars() as $id => $freeBusyCalendar) {
            /** @var Google_Service_Calendar_TimePeriod $busyTimePeriod */
            foreach ($freeBusyCalendar->getBusy() as $busyTimePeriod) {
                $freeBusy = (new GoogleFreeBusy)
                    ->setCalendar($id)
                    ->setStart(new \DateTime($busyTimePeriod->getStart()))
                    ->setEnd(new \DateTime($busyTimePeriod->getEnd()))
                    ->setType(FreeBusy::TYPE_BUSY);
                $freeBusyList[] = $freeBusy;
            }
        }

        return $freeBusyList;
    }

    public function events(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        throw new \Exception('@TODO');
    }
}
