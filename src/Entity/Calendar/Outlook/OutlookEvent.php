<?php

namespace App\Entity\Calendar\Outlook;

use App\Entity\Calendar\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Outlook\OutlookEventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookEvent extends Event
{
}
