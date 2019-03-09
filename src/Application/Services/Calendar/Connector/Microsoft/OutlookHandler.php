<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Repository\AuthTokenRepository;
use App\Repository\OutlookAuthTokenRepository;

class OutlookHandler extends MicrosoftHandler
{
    public const ALIAS = 'outlook';

    public function __construct(OutlookAuthTokenRepository $authTokenRepository)
    {
//        parent::__construct($authTokenRepository);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }
}
