<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\GoogleToken", mappedBy="user")
     */
    private $googleToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GoogleCalendar", mappedBy="user")
     */
    private $googleCalendars;

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
     * @return mixed
     */
    public function getGoogleToken()
    {
        return $this->googleToken;
    }

    public function setGoogleToken(GoogleToken $googleToken): self
    {
        $this->googleToken = $googleToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoogleCalendars()
    {
        return $this->googleCalendars;
    }

    /**
     * @param mixed $googleCalendars
     */
    public function setGoogleCalendars($googleCalendars): self
    {
        $this->googleCalendars = $googleCalendars;

        return $this;
    }
}
