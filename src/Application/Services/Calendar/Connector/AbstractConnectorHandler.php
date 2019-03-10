<?php

namespace App\Application\Services\Calendar\Connector;

use App\Application\Services\Calendar\AbstractHandler;
use App\Entity\AccountUser;
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

    public function isRegistered(AccountUser $accountUser): bool
    {
        return null !== $this->authTokenRepository->findOneBy(['user' => $accountUser]);
    }

    public function getToken(AccountUser $accountUser): AuthToken
    {
        /** @var AuthToken $token */
        $token = $this->authTokenRepository->findOneBy(['accountUser' => $accountUser]);

        if ($token->hasExpired()) {
            $token = $this->refreshAccessToken($token);
        }

        return $token;
    }

    public function fetchAccessToken(string $authCode): AccessTokenInterface
    {
        $token = $this->getProvider()->getAccessToken('authorization_code', ['code' => $authCode]);

        return $token;
    }

    protected function refreshAccessToken(AuthToken $authToken): AuthToken
    {
        $grant = new RefreshToken;

        $token = $this->getProvider()->getAccessToken($grant, ['refresh_token' => $authToken->getRefreshToken()]);

        $authToken->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($authToken);

        return $authToken;
    }

    abstract public function getAuthUrl(AccountUser $accountUser): string;

    abstract public function persist(AccessTokenInterface $token, AccountUser $accountUser): AuthToken;

    abstract protected function getProvider(): AbstractProvider;
}
