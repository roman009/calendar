<?php

namespace App\Service\Calendar\Connector;

use App\Entity\AccountUser;
use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\CalendarServiceProvider;
use App\Service\Calendar\Connector\Response\RegisterFailResponse;
use App\Service\Calendar\Connector\Response\RegisterOAuthAuthUrlResponse;
use App\Service\Calendar\Connector\Response\RegisterResponse;
use App\Service\Calendar\Connector\Response\RegisterSuccessResponse;
use App\Service\Calendar\Connector\Response\RegisterUserPasswordRequestResponse;

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

    public function register(AccountUser $accountUser, CalendarServiceProvider $service, string $authCode = null, string $username = null, string $password = null): RegisterResponse
    {
        $handler = $this->connectorRegistry->getConnectorAdapter($service);

        if ($handler instanceof OAuthConnectorInterface) {
            return $this->registerOAuth($accountUser, $handler, $authCode);
        }

        if ($handler instanceof UserPasswordConnectorInterface) {
            return $this->registerUserPassword($accountUser, $handler, $username, $password);
        }

        throw new \Exception('Registration method not supported');
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
    private function registerOAuth(AccountUser $accountUser, AbstractConnectorAdapter $handler, string $authCode = null): RegisterResponse
    {
        if (null === $authCode) {
            $authUrl = $handler->getAuthUrl($accountUser);
            return new RegisterOAuthAuthUrlResponse($authUrl);
        }

//        echo $handler->getAuthUrl($accountUser) . PHP_EOL;

//        $authCode = trim(fgets(STDIN));

        $token = $handler->fetchAccessToken($authCode);

        $handler->persist($token, $accountUser);

        return new RegisterSuccessResponse;
    }

    /**
     * @param AccountUser $accountUser
     * @param AbstractConnectorAdapter $handler
     * @param string $username
     * @param string $password
     */
    private function registerUserPassword(AccountUser $accountUser, AbstractConnectorAdapter $handler, string $username = null, string $password = null): RegisterResponse
    {
        if (null === $username || null === $password) {
            return new RegisterUserPasswordRequestResponse;
        }
        if ($handler->validate($username, $password)) {
            $handler->saveUsernamePasswordToken($accountUser, $username, $password);

            return new RegisterSuccessResponse;
        }

        return new RegisterFailResponse;
    }
}
