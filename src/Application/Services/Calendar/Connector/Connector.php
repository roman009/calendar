<?php

namespace App\Application\Services\Calendar\Connector;

use App\Entity\AuthToken;
use App\Entity\User;
use App\Repository\UserRepository;

class Connector
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var iterable
     */
    private $services;
    /**
     * @var ConnectorRegistry
     */
    private $connectorRegistry;

    public function __construct(UserRepository $userRepository, ConnectorRegistry $connectorRegistry)
    {
        $this->userRepository = $userRepository;
        $this->connectorRegistry = $connectorRegistry;
    }

    public function connect(User $user, string $service)
    {

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