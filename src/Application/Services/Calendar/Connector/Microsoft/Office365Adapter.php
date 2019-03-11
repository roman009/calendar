<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Entity\AccountUser;
use App\Entity\AuthToken;
use App\Entity\Office365AuthToken;
use App\Repository\Office365AuthTokenRepository;
use League\OAuth2\Client\Token\AccessTokenInterface;

class Office365Adapter extends MicrosoftAdapter
{
    public const ALIAS = 'office365';

    public function __construct(Office365AuthTokenRepository $authTokenRepository)
    {
        parent::__construct($authTokenRepository);
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
}