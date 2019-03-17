<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Account
{
    use BaseEntityTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Collection<AccountUser>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\AccountUser", mappedBy="account")
     */
    private $accountUsers;

    /**
     * @ORM\ManyToMany(targetEntity="AccountAdmin", mappedBy="account")
     */
    private $accountAdmins;

    public function __construct()
    {
        $this->accountAdmins = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsers()
    {
        return array_map(function (AccountUser $accountUser) {
            return $accountUser->getUser();
        }, $this->accountUsers->toArray());
    }

    /**
     * @return Collection<AccountUser>
     */
    public function getAccountUsers(): Collection
    {
        return $this->accountUsers;
    }

    /**
     * @return Collection|AccountAdmin[]
     */
    public function getAccountAdmins(): Collection
    {
        return $this->accountAdmins;
    }

    public function addAccountAdmin(AccountAdmin $accountAdmin): self
    {
        if (!$this->accountAdmins->contains($accountAdmin)) {
            $this->accountAdmins[] = $accountAdmin;
            $accountAdmin->addAccount($this);
        }

        return $this;
    }

    public function removeAccountAdmin(AccountAdmin $accountAdmin): self
    {
        if ($this->accountAdmins->contains($accountAdmin)) {
            $this->accountAdmins->removeElement($accountAdmin);
            $accountAdmin->removeAccount($this);
        }

        return $this;
    }
}
