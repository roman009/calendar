<?php

namespace App\Service\Calendar\Fetch\Google;

use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Calendar;
use App\Entity\Calendar\Event;
use App\Entity\Calendar\FreeBusy;
use App\Entity\Calendar\Google\GoogleCalendar;
use App\Entity\Calendar\Google\GoogleEvent;
use App\Entity\Calendar\Google\GoogleFreeBusy;
use App\Repository\Calendar\Google\GoogleCalendarRepository;
use App\Service\Calendar\Fetch\AbstractFetchAdapter;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_FreeBusyCalendar;
use Google_Service_Calendar_FreeBusyRequest;
use Google_Service_Calendar_FreeBusyRequestItem;
use Google_Service_Calendar_TimePeriod;

class GoogleAdapter extends AbstractFetchAdapter
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return array<GoogleCalendar>
     */
    public function calendars(AuthToken $token): array
    {
        $this->client->setAccessToken($token->getAccessToken());

        $service = new Google_Service_Calendar($this->client);
        $calendars = [];

        try {
            $googleCalendars = $service->calendarList->listCalendarList();
        } catch (\Google_Exception $exception) {
            $exception = json_decode($exception->getMessage(), true);
            throw new \Exception($exception['error']['message']);
        }

        /** @var Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($googleCalendars as $calendar) {
            $googleCalendar = $this->googleCalendarRepository->findOneBy(['accountUser' => $token->getAccountUser(), 'calendarId' => $calendar->getId()]);
            if (null === $googleCalendar) {
                $googleCalendar = new GoogleCalendar;
            }
            $googleCalendar
                ->setDescription($calendar->getDescription())
                ->setSummary($calendar->getSummaryOverride() ?? $calendar->getSummary())
                ->setTimezone($calendar->getTimeZone())
                ->setPrimary($calendar->getPrimary() ?? false)
                ->setCalendarId($calendar->getId())
                ->setAccountUser($token->getAccountUser());
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

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $calendarId
     * @param string|null $timezone
     *
     * @throws \Exception
     *
     * @return array<Event>
     */
    public function events(AuthToken $token, \DateTime $startDate, \DateTime $endDate, string $calendarId, string $timezone = null): array
    {
        $calendar = $this->googleCalendarRepository->findOneBy(['accountUser' => $token->getAccountUser(), 'objectId' => $calendarId]);

        $this->client->setAccessToken($token->getAccessToken());

        $service = new Google_Service_Calendar($this->client);

        $eventList = [];

        $optParams = [
            'timeZone' => $timezone,
            'timeMin' => $startDate->format(DATE_ATOM),
            'timeMax' => $endDate->format(DATE_ATOM),
        ];

        try {
            $response = $service->events->listEvents($calendar->getCalendarId(), $optParams);
        } catch (\Google_Exception $exception) {
            $exception = json_decode($exception->getMessage(), true);
            throw new \Exception($exception['error']['message']);
        }

        /** @var Google_Service_Calendar_Event $item */
        foreach ($response->getItems() as $item) {
            $googleEvent = (new GoogleEvent)
                ->setName($item->getSummary())
                ->setStart(new \DateTime($item->getStart()->getDateTime()))
                ->setEnd(new \DateTime($item->getEnd()->getDateTime()))
                ->setTimezone($item->getStart()->getTimeZone())
                ->setEventId($item->getId());
            $eventList[] = $googleEvent;
        }

        return $eventList;
    }
}
