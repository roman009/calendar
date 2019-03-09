<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppleAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AppleAuthToken extends AuthToken
{

}
