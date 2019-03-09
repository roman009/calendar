<?php

namespace App\Application\Services\Calendar\Fetch;

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

    public function calendars(string $service, AuthToken $token): array
    {
        $handler = $this->fetchRegistry->getFetchHandler($service);

        return $handler->calendars($token);
    }

    public function freeBusy(string $service, AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        $handler = $this->fetchRegistry->getFetchHandler($service);

        return $handler->freeBusy($token, $startDate, $endDate, $calendars, $timezone);
    }
}
