<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Repository\AuthTokenRepository;
use App\Repository\Office365AuthTokenRepository;

class Office365Handler extends MicrosoftHandler
{
    public const ALIAS = 'office365';

    public function __construct(Office365AuthTokenRepository $authTokenRepository)
    {
//        parent::__construct($authTokenRepository);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }
}
