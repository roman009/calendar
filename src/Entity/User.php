<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    use BaseEntityTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\AccountUser", mappedBy="user")
     */
    private $accountUsers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAccountUsers(): Collection
    {
        return $this->accountUsers;
    }

    /**
     * @param array $accountUsers
     * @return User
     */
    public function setAccountUsers(array $accountUsers): self
    {
        $this->accountUsers = $accountUsers;

        return $this;
    }
}
