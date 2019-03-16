<?php

namespace App\Entity\Calendar\Office365;

use App\Entity\Calendar\FreeBusy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Office365\Office365FreeBusyRepository")
 * @ORM\Table(name="office365_free_busy")
 * @ORM\HasLifecycleCallbacks
 */
class Office365FreeBusy extends FreeBusy
{
    use Office365ProviderTrait;
}
