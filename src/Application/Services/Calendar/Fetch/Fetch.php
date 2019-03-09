<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Application\Services\Calendar\Fetch\FetchRegistry;
use App\Entity\AuthToken;
use App\Entity\User;

class Fetch
{
    /**
     * @var FetchRegistry
     */
    private $fetchRegistry;

    public function __construct(FetchRegistry $fetchRegistry)
    {
        $this->fetchRegistry = $fetchRegistry;
    }

    public function calendars(User $user, string $service, AuthToken $token)
    {
        $handler = $this->fetchRegistry->getFetchHandler($service);

        return $handler->calendars($user, $token);
    }
}
