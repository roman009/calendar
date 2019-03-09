<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Office365AuthTokenRepository")
 * @ORM\Table(name="office365_auth_token")
 * @ORM\HasLifecycleCallbacks
 */
class Office365AuthToken extends AuthToken
{

}
