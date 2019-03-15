<?php

namespace App\Service\Calendar\Connector\Microsoft;

use App\Entity\AccountUser;
use App\Entity\AuthToken;
use App\Entity\ExchangeAuthToken;
use App\Repository\ExchangeAuthTokenRepository;
use App\Service\Calendar\Connector\Microsoft\Exchange\Autodiscover;
use App\Service\Calendar\Connector\Microsoft\Exchange\Client;
use App\Service\Calendar\Connector\UserPasswordConnectorInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

class ExchangeAdapter extends MicrosoftAdapter implements UserPasswordConnectorInterface
{
    public const ALIAS = 'exchange';

    public function __construct(ExchangeAuthTokenRepository $authTokenRepository)
    {
        parent::__construct($authTokenRepository);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    public function persist(AccessTokenInterface $token, AccountUser $accountUser): AuthToken
    {
        $this->authTokenRepository->persistAndFlush($token);

        return $token;
    }

    public function validate(string $username, string $password): bool
    {
        try {
            Autodiscover::getEWS($username, $password);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function saveUsernamePasswordToken(AccountUser $accountUser, string $username, string $password)
    {
        /** @var Client $client */
        $client = Autodiscover::getEWS($username, $password);
        $exchangeToken = (new ExchangeAuthToken)
            ->setUsername($username)
            ->setPassword($password)
            ->setAccountUser($accountUser)
            ->setVersion($client->getVersion())
            ->setServer($client->getServer())
            ->setExpires(time() + (60 * 60 * 24 * 365 * 10));

//        $this->persist($exchangeToken, $accountUser);
        $this->authTokenRepository->persistAndFlush($exchangeToken);

//        return $token;
    }
}
