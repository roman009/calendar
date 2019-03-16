<?php

namespace App\Service\Calendar\Fetch;

use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Calendar;
use App\Entity\Calendar\Event;
use App\Entity\Calendar\FreeBusy;
use App\Service\Calendar\AbstractHandler;

abstract class AbstractFetchAdapter extends AbstractHandler
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
