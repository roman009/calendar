<?php

namespace App\Service\Calendar\Connector\Response;

class RegisterOAuthAuthUrlResponse implements RegisterResponse
{
    /**
     * @var string
     */
    private $authUrl;

    public function __construct(string $authUrl)
    {
        $this->authUrl = $authUrl;
    }

    /**
     * @return string
     */
    public function getAuthUrl(): string
    {
        return $this->authUrl;
    }
}
