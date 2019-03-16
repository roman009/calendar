<?php

namespace App\Service\Calendar\Create;

use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Calendar;
use App\Entity\Calendar\Event;
use App\Service\Calendar\AbstractHandler;

abstract class AbstractCreateAdapter extends AbstractHandler
{
    /**
     * @param AuthToken $token
     * @param string $calendarName
     *
     * @return Calendar
     */
    abstract public function createCalendar(AuthToken $token, string $calendarName): Calendar;

    /**
     * @param AuthToken $token
     * @param string $eventName
     *
     * @return Event
     */
    abstract public function createEvent(AuthToken $token, string $eventName): Event;
}
