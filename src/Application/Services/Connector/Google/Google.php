<?php

namespace App\Application\Services\Connector\Google;

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

    public function __construct(\Google_Client $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $this->client->setApplicationName('Google Calendar API PHP Quickstart');
        $this->client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $this->client->setAuthConfig('credentials.json');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');


    }
}