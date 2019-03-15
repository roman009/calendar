<?php

namespace App\Service\Calendar\Connector\Microsoft;

use App\Service\Calendar\Connector\OAuthConnectorInterface;
use App\Entity\AccountUser;
use App\Entity\AuthToken;
use App\Entity\OutlookAuthToken;
use App\Repository\OutlookAuthTokenRepository;
use League\OAuth2\Client\Token\AccessTokenInterface;

class OutlookAdapter extends MicrosoftAdapter implements OAuthConnectorInterface
{
    public const ALIAS = 'outlook';

    public function __construct(OutlookAuthTokenRepository $authTokenRepository)
    {
        parent::__construct($authTokenRepository);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    public function persist(AccessTokenInterface $token, AccountUser $accountUser): AuthToken
    {
        $outlookAuthToken = (new OutlookAuthToken)
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
