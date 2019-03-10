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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="accountUsers")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    private $user;

    /**
     * @var Account
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="accountUsers")
     * @ORM\JoinColumn(fieldName="account_id", nullable=false, referencedColumnName="id")
     */
    private $account;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
