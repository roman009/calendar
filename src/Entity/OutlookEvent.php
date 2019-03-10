<?php

namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleEvent extends Event
{

}