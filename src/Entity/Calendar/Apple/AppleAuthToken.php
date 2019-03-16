<?php

namespace App\Entity\Calendar\Apple;

use App\Entity\Calendar\AuthToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppleAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AppleAuthToken extends AuthToken
{
}
