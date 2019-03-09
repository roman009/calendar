<?php

namespace App\Application\Services\Calendar\Connector;

use App\Application\Services\Calendar\AbstractHandler;
use App\Entity\AuthToken;
use App\Entity\User;
use App\Repository\AuthTokenRepository;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

abstract class AbstractConnectorHandler extends AbstractHandler
{
    /**
     * @var AuthTokenRepository
     */
    protected $authTokenRepository;

    public function __construct(AuthTokenRepository $authTokenRepository)
    {
        $this->authTokenRepository = $authTokenRepository;
    }

    public function isRegistered(User $user): bool
    {
        return null !== $this->authTokenRepository->findOneBy(['user' => $user]);
    }

    public function getToken(User $user): AuthToken
    {
        /** @var AuthToken $token */
        $token = $this->authTokenRepository->findOneBy(['user' => $user]);

        if ($token->hasExpired()) {
            $token = $this->refreshAccessToken($user, $token);
        }

        return $token;
    }

    public function fetchAccessToken(string $authCode): AccessTokenInterface
    {
        $token = $this->getProvider()->getAccessToken('authorization_code', ['code' => $authCode]);

        return $token;
    }

    protected function refreshAccessToken(User $user, AuthToken $authToken): AuthToken
    {
        $grant = new RefreshToken;

        $token = $this->getProvider()->getAccessToken($grant, ['refresh_token' => $authToken->getRefreshToken()]);

        $authToken->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($authToken);

        return $authToken;
    }

    abstract public function getAuthUrl(User $user): string;

    abstract public function persist(AccessTokenInterface $token, User $user): AuthToken;

    abstract protected function getProvider(): AbstractProvider;
}
