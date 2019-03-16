<?php

namespace App\Entity;

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
}
