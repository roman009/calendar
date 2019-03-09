<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookAuthToken extends AuthToken
{
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="outlookToken")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;
}
