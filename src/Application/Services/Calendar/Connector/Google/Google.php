<?php

namespace App\Application\Services\Calendar\Connector\Google;

use App\Entity\GoogleToken;
use App\Entity\User;
use App\Repository\GoogleTokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Google_Service_Calendar;

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

    public function __construct(\Google_Client $client, GoogleTokenRepository $googleTokenRepository)
    {
        $this->client = $client;
        $this->googleTokenRepository = $googleTokenRepository;
    }

    public function handle(User $user)
    {
        $this->client->setApplicationName('Google Calendar API PHP Quickstart');
        $this->client->setScopes([Google_Service_Calendar::CALENDAR_READONLY]);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        $googleToken = $this->googleTokenRepository->findOneBy(['user' => $user]);

        if (null !== $googleToken) {
            $this->client->setAccessToken($googleToken->getAccessToken());
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

                $googleToken = (new GoogleToken)
                    ->setAccessToken($token['access_token'])
                    ->setUser($user)
                    ->setRefreshToken($token['refresh_token'])
                    ->setScope($token['scope'])
                    ->setExpiresIn($token['expires_in']);
                $this->googleTokenRepository->persistAndFlush($googleToken);
            }
        }

    }
}