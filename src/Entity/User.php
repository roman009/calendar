<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    use BaseEntityTrait;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true, length=255)
     * @Assert\NotBlank
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
     *
     * @return User
     */
    public function setAccountUsers(array $accountUsers): self
    {
        $this->accountUsers = $accountUsers;

        return $this;
    }
}
