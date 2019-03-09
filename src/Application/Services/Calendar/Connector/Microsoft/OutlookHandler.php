<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Entity\AuthToken;
use App\Entity\User;
use App\Repository\AuthTokenRepository;
use App\Repository\OutlookAuthTokenRepository;

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

    public function isRegistered(User $user): bool
    {
        // TODO: Implement isRegistered() method.
    }

    public function getToken(User $user): AuthToken
    {
        // TODO: Implement getToken() method.
    }

    public function getAuthUrl(User $user): string
    {
        // TODO: Implement getAuthUrl() method.
    }
}