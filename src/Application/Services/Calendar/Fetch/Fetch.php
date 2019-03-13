<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\Event;
use App\Entity\FreeBusy;
use App\Entity\Service;

class Fetch
{
    /**
     * @var FetchAdapterRegistry
     */
    private $fetchRegistry;

    public function __construct(FetchAdapterRegistry $fetchRegistry)
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
    public function calendars(Service $service, AuthToken $token): array
    {
        $handler = $this->fetchRegistry->getFetchAdapter($service);

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
    public function freeBusy(Service $service, AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        $handler = $this->fetchRegistry->getFetchAdapter($service);

        return $handler->freeBusy($token, $startDate, $endDate, $calendars, $timezone);
    }

    /**
     * @param string $service
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $calendarId
     * @param string|null $timezone
     *
     * @throws \Exception
     *
     * @return array<Event>
     */
    public function events(Service $service, AuthToken $token, \DateTime $startDate, \DateTime $endDate, string $calendarId, string $timezone = null): array
    {
        $handler = $this->fetchRegistry->getFetchAdapter($service);

        return $handler->events($token, $startDate, $endDate, $calendarId, $timezone);
    }
}
