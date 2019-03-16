<?php

namespace App\Service\Calendar\Connector\Apple;

use App\Repository\Calendar\Apple\AppleAuthTokenRepository;
use App\Repository\Calendar\AuthTokenRepository;

class AppleAdapter /* extends AbstractConnectorHandler*/
{
    public const ALIAS = 'apple';

    public function __construct(AppleAuthTokenRepository $authTokenRepository)
    {
//        parent::__construct($authTokenRepository);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }
}
