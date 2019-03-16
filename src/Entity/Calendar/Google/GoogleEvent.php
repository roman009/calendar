<?php

namespace App\Entity\Calendar\Google;

use App\Entity\Calendar\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleEventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleEvent extends Event
{
}
