<?php

namespace App\Entity\Calendar\Exchange;

use App\Entity\Calendar\FreeBusy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Exchange\ExchangeFreeBusyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ExchangeFreeBusy extends FreeBusy
{
    use ExchangeProviderTrait;
}
