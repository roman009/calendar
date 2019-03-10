<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OutlookAuthToken extends AuthToken
{
    use OutlookProviderTrait;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="outlookTokens")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;
}
