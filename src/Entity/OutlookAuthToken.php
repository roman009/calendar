<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OutlookAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookAuthToken extends AuthToken
{
}
