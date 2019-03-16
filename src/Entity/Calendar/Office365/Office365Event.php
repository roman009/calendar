<?php

namespace App\Entity\Calendar\Office365;

use App\Entity\Calendar\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Office365\Office365EventRepository")
 * @ORM\Table(name="office365_event")
 * @ORM\HasLifecycleCallbacks
 */
class Office365Event extends Event
{
}
