<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleCalendarRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"user_id", "calendar_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class GoogleCalendar extends Calendar
{
}
