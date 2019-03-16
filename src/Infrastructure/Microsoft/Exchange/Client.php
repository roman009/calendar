<?php

namespace App\Infrastructure\Microsoft\Exchange;

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
