<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleFreeBusyRepository")
 */
class GoogleFreeBusy extends FreeBusy
{
    use GoogleProviderTrait;
}
