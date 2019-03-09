<?php

namespace App\Application\Services\Calendar\Fetch\Google;

use App\Application\Services\Calendar\Fetch\AbstractFetchHandler;
use App\Entity\AuthToken;
use App\Entity\GoogleCalendar;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;

class GoogleHandler extends AbstractFetchHandler
{
    public const ALIAS = 'google';
    /**
     * @var \Google_Client
     */
    private $client;

    public function __construct(\Google_Client $client)
    {
        $this->client = $client;
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    /**
     * @param AuthToken $token
     * @return array<GoogleCalendar>
     */
    protected function fetchCalendars(AuthToken $token): array
    {
        $this->client->setAccessToken($token->getAccessToken());

        $service = new Google_Service_Calendar($this->client);
        $calendars = [];

        /** @var Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($service->calendarList->listCalendarList() as $calendar) {
            $googleCalendar = new GoogleCalendar;
            $googleCalendar
                ->setDescription($calendar->getDescription())
                ->setSummary($calendar->getSummaryOverride() ?? $calendar->getSummary())
                ->setTimezone($calendar->getTimeZone())
                ->setPrimary($calendar->getPrimary() ?? false)
                ->setCalendarId($calendar->getId());
            $calendars[] = $googleCalendar;
        }

        return $calendars;
    }
}