<?php

namespace App\Application\Services\Calendar\Connector;

use App\Entity\AuthToken;
use App\Entity\User;

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

    public function isRegistered(User $user, string $service): bool
    {
        $handler = $this->connectorRegistry->getConnectorHandler($service);

        return $handler->isRegistered($user);
    }

    public function register(User $user, string $service)
    {
        $handler = $this->connectorRegistry->getConnectorHandler($service);

        echo $handler->getAuthUrl($user) . PHP_EOL;

        $authCode = trim(fgets(STDIN));

        $token = $handler->fetchAccessToken($authCode);

        $handler->persist($token, $user);
    }

    public function getToken(User $user, string $service): AuthToken
    {
        $handler = $this->connectorRegistry->getConnectorHandler($service);

        return $handler->getToken($user);
    }
}
