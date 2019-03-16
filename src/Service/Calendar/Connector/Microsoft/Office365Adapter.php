<?php

namespace App\Service\Calendar\Connector\Microsoft;

use App\Entity\AccountUser;
use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Office365\Office365AuthToken;
use App\Repository\Calendar\Office365\Office365AuthTokenRepository;
use App\Service\Calendar\Connector\OAuthConnectorInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class Office365Adapter extends MicrosoftAdapter implements OAuthConnectorInterface
{
    public const ALIAS = 'office365';

    public function __construct(Office365AuthTokenRepository $authTokenRepository, RouterInterface $router)
    {
        parent::__construct($authTokenRepository, $router);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    public function persist(AccessTokenInterface $token, AccountUser $accountUser): AuthToken
    {
        $outlookAuthToken = (new Office365AuthToken)
            ->setAccountUser($accountUser)
            ->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($outlookAuthToken);

        return $outlookAuthToken;
    }

    public function validate(string $username, string $password): bool
    {
        throw new \Exception('This shouldn\'t be called here');
    }

    public function saveUsernamePasswordToken(AccountUser $accountUser, string $username, string $password)
    {
        throw new \Exception('This shouldn\'t be called here');
    }
}
