<?php

namespace App\Service\Calendar\Connector\Microsoft;

use App\Entity\AccountUser;
use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Exchange\ExchangeAuthToken;
use App\Infrastructure\Microsoft\Exchange\Autodiscover;
use App\Infrastructure\Microsoft\Exchange\Client;
use App\Repository\Calendar\Exchange\ExchangeAuthTokenRepository;
use App\Service\Calendar\Connector\UserPasswordConnectorInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\Routing\RouterInterface;

class ExchangeAdapter extends MicrosoftAdapter implements UserPasswordConnectorInterface
{
    public const ALIAS = 'exchange';

    public function __construct(ExchangeAuthTokenRepository $authTokenRepository, RouterInterface $router)
    {
        parent::__construct($authTokenRepository, $router);
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

    public function validate(string $username, string $password, string $server = null): bool
    {
        try {
//            Autodiscover::getEWS($username, $password, $server);
            Autodiscover::getEWS($username, $password, null, 'mail.xing.com');
        } catch (\Exception $e) {
            dump($e); die();
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
