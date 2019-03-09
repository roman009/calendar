<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountUserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AccountUser
{
    use BaseEntityTrait;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="accounts")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    private $user;

    /**
     * @var Account
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="users")
     * @ORM\JoinColumn(fieldName="account_id", nullable=false, referencedColumnName="id")
     */
    private $account;
}
