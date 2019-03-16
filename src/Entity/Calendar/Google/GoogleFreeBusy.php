<?php

namespace App\Entity\Calendar\Google;

use App\Entity\Calendar\FreeBusy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Google\GoogleFreeBusyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleFreeBusy extends FreeBusy
{
    use GoogleProviderTrait;
}
