<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Office365AuthTokenRepository")
 * @ORM\Table(name="office365_auth_token")
 * @ORM\HasLifecycleCallbacks
 */
class Office365AuthToken extends AuthToken
{
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="office365Token")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;
}
