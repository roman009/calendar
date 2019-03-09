<?php

namespace App\Application\Services\Calendar\Connector;

use App\Entity\AuthToken;
use App\Entity\User;
use App\Repository\AuthTokenRepository;

abstract class AbstractConnectorHandler
{
    /**
     * @var AuthTokenRepository
     */
    protected $authTokenRepository;

    public function __construct(AuthTokenRepository $authTokenRepository)
    {
        $this->authTokenRepository = $authTokenRepository;
    }

    abstract public static function alias(): string;

    public function isRegistered(User $user): bool
    {
        return null !== $this->authTokenRepository->findOneBy(['user' => $user]);
    }

    public function getToken(User $user): AuthToken
    {
        return $this->authTokenRepository->findOneBy(['user' => $user]);
    }

}