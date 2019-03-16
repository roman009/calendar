<?php

namespace App\Entity\Calendar\Exchange;

use App\Entity\Calendar\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeEventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ExchangeEvent extends Event
{
}
