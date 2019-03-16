<?php

namespace App\Entity\Calendar\Outlook;

use App\Entity\Calendar\FreeBusy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Outlook\OutlookFreeBusyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookFreeBusy extends FreeBusy
{
    use OutlookProviderTrait;
}
