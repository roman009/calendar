<?php

namespace App\Entity\Calendar\Office365;

use App\Entity\Calendar\AuthToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Office365AuthTokenRepository")
 * @ORM\Table(name="office365_auth_token")
 * @ORM\HasLifecycleCallbacks
 */
class Office365AuthToken extends AuthToken
{
}
