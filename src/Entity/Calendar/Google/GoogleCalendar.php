<?php

namespace App\Entity\Calendar\Google;

use App\Entity\Calendar\Calendar;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Google\GoogleCalendarRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "calendar_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class GoogleCalendar extends Calendar
{
    use GoogleProviderTrait;
}
