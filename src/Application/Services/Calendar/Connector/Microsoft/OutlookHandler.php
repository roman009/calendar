<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Entity\AuthToken;
use App\Entity\OutlookAuthToken;
use App\Entity\User;
use App\Repository\AuthTokenRepository;
use App\Repository\OutlookAuthTokenRepository;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

class OutlookHandler extends MicrosoftHandler
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

    public function fetchAccessToken(string $authCode): AccessTokenInterface
    {
        // TODO: Implement fetchAccessToken() method.
    }

    public function persist(AccessTokenInterface $token, User $user): AuthToken
    {
        $googleToken = (new OutlookAuthToken)
            ->setUser($user)
            ->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($googleToken);

        return $googleToken;
    }

    protected function refreshAccessToken(User $user, AuthToken $token): AuthToken
    {
        // TODO: Implement refreshAccessToken() method.
    }


}
