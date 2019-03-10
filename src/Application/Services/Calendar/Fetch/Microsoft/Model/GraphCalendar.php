<?php

namespace App\Application\Services\Calendar\Fetch\Microsoft\Model;

use Microsoft\Graph\Model\Calendar;

class GraphCalendar extends Calendar
{
    /**
     * Gets the schedule items
     *
     * @return array|null
     */
    public function getScheduleItems()
    {
        if (array_key_exists('scheduleItems', $this->_propDict)) {
            return $this->_propDict['scheduleItems'];
        }

        return null;
    }

    public function getScheduleId()
    {
        if (array_key_exists('scheduleId', $this->_propDict)) {
            return $this->_propDict['scheduleId'];
        }

        return null;
    }
}
