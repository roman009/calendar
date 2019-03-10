<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookEventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookEvent extends Event
{
}
