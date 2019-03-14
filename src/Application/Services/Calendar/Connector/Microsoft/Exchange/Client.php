<?php

namespace App\Application\Services\Calendar\Connector\Microsoft\Exchange;

class Client extends \jamesiarmes\PhpEws\Client
{
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

}