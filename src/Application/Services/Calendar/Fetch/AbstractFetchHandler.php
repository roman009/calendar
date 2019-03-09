<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Application\Services\Calendar\AbstractHandler;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\FreeBusy;
use App\Entity\User;

abstract class AbstractFetchHandler extends AbstractHandler
{
    public function calendars(AuthToken $token): array
    {
        $calendars = $this->fetchCalendars($token);

        return $calendars;
    }

    /**
     * @param AuthToken $token
     *
     * @return array<Calendar>
     */
    abstract protected function fetchCalendars(AuthToken $token): array;

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param array $calendars
     * @param string|null $timezone
     * @return array<FreeBusy>
     */
    abstract public function freeBusy(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array;
}
