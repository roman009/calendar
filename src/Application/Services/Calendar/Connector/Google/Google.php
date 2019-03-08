<?php

namespace App\Application\Services\Calendar\Connector\Google;

use App\Entity\GoogleCalendar;
use App\Entity\GoogleToken;
use App\Entity\User;
use App\Repository\GoogleCalendarRepository;
use App\Repository\GoogleTokenRepository;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;

/**
 * Class Google
 * @package App\Application\Services\Connector
 *
 * https://developers.google.com/calendar/quickstart/php
 */
class Google
{
    /**
     * @var \Google_Client
     */
    private $client;
    /**
     * @var GoogleTokenRepository
     */
    private $googleTokenRepository;
    /**
     * @var GoogleCalendarRepository
     */
    private $googleCalendarRepository;

    public function __construct(\Google_Client $client, GoogleTokenRepository $googleTokenRepository, GoogleCalendarRepository $googleCalendarRepository)
    {
        $this->client = $client;
        $this->googleTokenRepository = $googleTokenRepository;
        $this->googleCalendarRepository = $googleCalendarRepository;
    }

    public function handle(User $user)
    {
        $this->client->setApplicationName('Google Calendar API PHP Quickstart');
        $this->client->setScopes([Google_Service_Calendar::CALENDAR_READONLY]);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        $googleToken = $this->googleTokenRepository->findOneBy(['user' => $user]);

        if (null !== $googleToken && $googleToken->getJson()) {
            $this->client->setAccessToken($googleToken->getJson());
        }

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            } else {
                $this->client->setRedirectUri('https://calendar.test.buzila.ro');
                $authUrl = $this->client->createAuthUrl();
                echo $authUrl . PHP_EOL;

                $authCode = trim(fgets(STDIN));

                $token = $this->client->fetchAccessTokenWithAuthCode($authCode);
                $this->client->setAccessToken($token);

                if (array_key_exists('error', $token)) {
                    throw new \Exception(implode(', ', $token));
                }

                if (null !== $googleToken) {
                    $this->googleTokenRepository->delete($googleToken);
                }

                $googleToken = (new GoogleToken)
                    ->setAccessToken($token['access_token'])
                    ->setUser($user)
                    ->setRefreshToken($token['refresh_token'])
                    ->setScope($token['scope'])
                    ->setExpiresIn($token['expires_in'])
                    ->setJson(json_encode($token));
                $this->googleTokenRepository->persistAndFlush($googleToken);
            }
        }

        $service = new Google_Service_Calendar($this->client);

        /** @var Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($service->calendarList->listCalendarList() as $calendar) {
            $googleCalendar = $this->googleCalendarRepository->findOneBy(['user' => $user, 'calendarId' => $calendar->getId()]);
            if (null === $googleCalendar) {
                $googleCalendar = new GoogleCalendar;
            }
            $googleCalendar
                ->setDescription($calendar->getDescription())
                ->setSummary($calendar->getSummaryOverride() ?? $calendar->getSummary())
                ->setTimezone($calendar->getTimeZone())
                ->setPrimary($calendar->getPrimary() ?? false);
            $this->googleCalendarRepository->persistAndFlush($googleCalendar);
        }
    }
}