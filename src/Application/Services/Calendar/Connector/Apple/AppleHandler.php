<?php

namespace App\Application\Services\Calendar\Connector\Apple;

use App\Application\Services\Calendar\Connector\AbstractConnectorHandler;
use App\Repository\AppleAuthTokenRepository;
use App\Repository\AuthTokenRepository;

class AppleHandler /* extends AbstractConnectorHandler*/
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
