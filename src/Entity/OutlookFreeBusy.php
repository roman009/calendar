<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookFreeBusyRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookFreeBusy extends FreeBusy
{
    use OutlookProviderTrait;
}
