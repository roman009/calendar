<?php

namespace App\Application\Services\Calendar\Connector;

use App\Entity\AccountUser;
use App\Entity\AuthToken;

class Connector
{
    /**
     * @var ConnectorRegistry
     */
    private $connectorRegistry;

    public function __construct(ConnectorRegistry $connectorRegistry)
    {
        $this->connectorRegistry = $connectorRegistry;
    }

    public function isRegistered(AccountUser $accountUser, string $service): bool
    {
        $handler = $this->connectorRegistry->getConnectorHandler($service);

        return $handler->isRegistered($accountUser);
    }

    public function register(AccountUser $accountUser, string $service)
    {
        $handler = $this->connectorRegistry->getConnectorHandler($service);

        echo $handler->getAuthUrl($accountUser) . PHP_EOL;

        $authCode = trim(fgets(STDIN));

        $token = $handler->fetchAccessToken($authCode);

        $handler->persist($token, $accountUser);
    }

    public function getToken(AccountUser $accountUser, string $service): AuthToken
    {
        $handler = $this->connectorRegistry->getConnectorHandler($service);

        return $handler->getToken($accountUser);
    }
}
