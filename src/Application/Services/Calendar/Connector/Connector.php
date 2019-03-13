<?php

namespace App\Application\Services\Calendar\Connector;

use App\Entity\AccountUser;
use App\Entity\AuthToken;
use App\Entity\Service;

class Connector
{
    /**
     * @var ConnectorAdapterRegistry
     */
    private $connectorRegistry;

    public function __construct(ConnectorAdapterRegistry $connectorRegistry)
    {
        $this->connectorRegistry = $connectorRegistry;
    }

    public function isRegistered(AccountUser $accountUser, string $service): bool
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        return $handler->isRegistered($accountUser);
    }

    public function register(AccountUser $accountUser, string $service)
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        echo $handler->getAuthUrl($accountUser) . PHP_EOL;

        $authCode = trim(fgets(STDIN));

        $token = $handler->fetchAccessToken($authCode);

        $handler->persist($token, $accountUser);
    }

    public function getToken(AccountUser $accountUser, Service $service): AuthToken
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        return $handler->getToken($accountUser);
    }
}
