<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Entity\AuthToken;
use App\Entity\Office365AuthToken;
use App\Entity\User;
use App\Repository\Office365AuthTokenRepository;
use League\OAuth2\Client\Token\AccessTokenInterface;

class Office365Handler extends MicrosoftHandler
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

    public function persist(AccessTokenInterface $token, User $user): AuthToken
    {
        $outlookAuthToken = (new Office365AuthToken)
            ->setUser($user)
            ->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($outlookAuthToken);

        return $outlookAuthToken;
    }
}
