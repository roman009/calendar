<?php

namespace App\Entity\Calendar\Outlook;

use App\Entity\Calendar\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookEventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookEvent extends Event
{
}
