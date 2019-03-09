<?php

namespace App\Application\Services\Calendar\Connector\Google;

use App\Application\Services\Calendar\Connector\AbstractConnectorHandler;
use App\Entity\AuthToken;
use App\Entity\GoogleCalendar;
use App\Entity\GoogleAuthToken;
use App\Entity\User;
use App\Repository\GoogleCalendarRepository;
use App\Repository\GoogleAuthTokenRepository;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * Class Google
 * @package App\Application\Services\Connector
 *
 * https://developers.google.com/calendar/quickstart/php
 */
class GoogleHandler extends AbstractConnectorHandler
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

    /**
     * @var AbstractProvider
     */
    private $provider;

    public function __construct(GoogleAuthTokenRepository $googleTokenRepository, GoogleCalendarRepository $googleCalendarRepository, \Google_Client $client)
    {
        $this->client = $client;
        $this->googleCalendarRepository = $googleCalendarRepository;
        parent::__construct($googleTokenRepository);
    }









    public function handle(User $user)
    {
        $this->client->setApplicationName('Google Calendar API PHP Quickstart');
        $this->client->setScopes([Google_Service_Calendar::CALENDAR_READONLY]);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        $googleToken = $this->authTokenRepository->findOneBy(['user' => $user]);

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
                    $this->authTokenRepository->delete($googleToken);
                }

                $googleToken = (new GoogleAuthToken)
                    ->setAccessToken($token['access_token'])
                    ->setUser($user)
                    ->setRefreshToken($token['refresh_token'])
                    ->setScope($token['scope'])
                    ->setExpiresIn($token['expires_in'])
                    ->setJson(json_encode($token));
                $this->authTokenRepository->persistAndFlush($googleToken);
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

    public static function alias(): string
    {
        return self::ALIAS;
    }

    public function getAuthUrl(User $user): string
    {
        return $this->getProvider()->getAuthorizationUrl(['prompt' => 'consent']);
    }

    private function getProvider(): AbstractProvider
    {
        if (null === $this->provider) {
            $this->provider = new Google([
                'clientId' => getenv('GOOGLE_CLIENT_ID'),
                'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
                'redirectUri' => 'https://calendar.test.buzila.ro',
                'accessType' => 'offline',
                'scopes' => ['https://www.googleapis.com/auth/calendar'],
            ]);
        }

        return $this->provider;
    }

    public function fetchAccessToken(string $authCode): AccessTokenInterface
    {
        $token = $this->getProvider()->getAccessToken('authorization_code', ['code' => $authCode]);

        return $token;
    }

    public function persist(AccessTokenInterface $token, User $user): AuthToken
    {
        $googleToken = (new GoogleAuthToken)
            ->setUser($user)
            ->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setScope('https://www.googleapis.com/auth/calendar')
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($googleToken);

        return $googleToken;
    }

    protected function refreshAccessToken(User $user, AuthToken $googleToken): AuthToken
    {
        $grant = new RefreshToken;

        $token = $this->getProvider()->getAccessToken($grant, ['refresh_token' => $googleToken->getRefreshToken()]);

        $googleToken->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($googleToken);

        return $googleToken;
    }
}
