<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait BaseAccountUserEntityTrait
{
    /**
     * @var AccountUser
     * @ORM\ManyToOne(targetEntity="App\Entity\AccountUser")
     * @ORM\JoinColumn(fieldName="account_user_id", nullable=false, referencedColumnName="id")
     */
    protected $accountUser;

    /**
     * @return AccountUser
     */
    public function getAccountUser(): AccountUser
    {
        return $this->accountUser;
    }

    /**
     * @param AccountUser $accountUser
     *
     * @return self
     */
    public function setAccountUser(AccountUser $accountUser): self
    {
        $this->accountUser = $accountUser;

        return $this;
    }
}
