<?php

namespace App\Application\Services\Calendar\Fetch\Microsoft\CustomModel;

use Microsoft\Graph\Model\Calendar as GraphCalendar;

class Calendar extends GraphCalendar
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
        } else {
            return null;
        }
    }

    public function getScheduleId()
    {
        if (array_key_exists('scheduleId', $this->_propDict)) {
            return $this->_propDict['scheduleId'];
        } else {
            return null;
        }
    }
}