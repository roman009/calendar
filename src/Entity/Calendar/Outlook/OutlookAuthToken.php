<?php

namespace App\Entity\Calendar\Outlook;

use App\Entity\Calendar\AuthToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Outlook\OutlookAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookAuthToken extends AuthToken
{
    use OutlookProviderTrait;
}
