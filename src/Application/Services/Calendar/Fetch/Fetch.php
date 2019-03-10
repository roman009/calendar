<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\FreeBusy;

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

    /**
     * @param string $service
     * @param AuthToken $token
     *
     * @throws \Exception
     *
     * @return array<Calendar>
     */
    public function calendars(string $service, AuthToken $token): array
    {
        $handler = $this->fetchRegistry->getFetchHandler($service);

        return $handler->calendars($token);
    }

    /**
     * @param string $service
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param array $calendars
     * @param string|null $timezone
     *
     * @throws \Exception
     *
     * @return array<FreeBusy>
     */
    public function freeBusy(string $service, AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        $handler = $this->fetchRegistry->getFetchHandler($service);

        return $handler->freeBusy($token, $startDate, $endDate, $calendars, $timezone);
    }

    /**
     * @param string $service
     * @param string $calendarId
     * @param AuthToken $token
     *
     * @return array<Event>
     */
    public function events(string $service, string $calendarId, AuthToken $token): array
    {
    }
}
