<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Application\Services\Calendar\AbstractHandler;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\FreeBusy;

abstract class AbstractFetchHandler extends AbstractHandler
{
    /**
     * @param AuthToken $token
     *
     * @return array<Calendar>
     */
    abstract public function calendars(AuthToken $token): array;

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param array $calendars
     * @param string|null $timezone
     *
     * @return array<FreeBusy>
     */
    abstract public function freeBusy(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array;

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $calendarId
     * @param string|null $timezone
     *
     * @return array<Event>
     */
    abstract public function events(AuthToken $token, \DateTime $startDate, \DateTime $endDate, string $calendarId, string $timezone = null): array;
}
