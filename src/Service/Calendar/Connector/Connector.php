<?php

namespace App\Service\Calendar\Connector;

use App\Entity\AccountUser;
use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\CalendarServiceProvider;

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

    public function isRegistered(AccountUser $accountUser, CalendarServiceProvider $service): bool
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        return $handler->isRegistered($accountUser);
    }

    public function register(AccountUser $accountUser, CalendarServiceProvider $service, string $username = null, string $password = null)
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        if ($handler instanceof OAuthConnectorInterface) {
            $this->registerOAuth($accountUser, $handler);
        } elseif ($handler instanceof UserPasswordConnectorInterface) {
            $this->registerUserPassword($accountUser, $handler, $username, $password);
        }
    }

    public function getToken(AccountUser $accountUser, CalendarServiceProvider $service): ?AuthToken
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        return $handler->getToken($accountUser);
    }

    /**
     * TODO: make this non cli only
     *
     * @param AccountUser $accountUser
     * @param $handler
     */
    private function registerOAuth(AccountUser $accountUser, AbstractConnectorAdapter $handler): void
    {
        echo $handler->getAuthUrl($accountUser) . PHP_EOL;

        $authCode = trim(fgets(STDIN));

        $token = $handler->fetchAccessToken($authCode);

        $handler->persist($token, $accountUser);
    }

    /**
     * @param AccountUser $accountUser
     * @param AbstractConnectorAdapter $handler
     * @param string $username
     * @param string $password
     */
    private function registerUserPassword(AccountUser $accountUser, AbstractConnectorAdapter $handler, string $username, string $password)
    {
        if ($handler->validate($username, $password)) {
            $handler->saveUsernamePasswordToken($accountUser, $username, $password);
        }
    }
}
