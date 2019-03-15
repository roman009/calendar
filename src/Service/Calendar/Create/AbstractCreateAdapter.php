<?php

namespace App\Service\Calendar\Create;

use App\Service\Calendar\AbstractHandler;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\Event;

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
