<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookFreeBusyRepository")
 */
class OutlookFreeBusy extends FreeBusy
{
    use OutlookProviderTrait;
}
