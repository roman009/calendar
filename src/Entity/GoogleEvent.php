<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleEventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleEvent extends Event
{
}
