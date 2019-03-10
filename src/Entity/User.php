<?php

namespace App\Entity;

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
     * @ORM\OneToMany(targetEntity="GoogleAuthToken", mappedBy="user")
     */
    private $googleTokens;
    /**
     * @ORM\OneToMany(targetEntity="OutlookAuthToken", mappedBy="user")
     */
    private $outlookTokens;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GoogleCalendar", mappedBy="user")
     */
    private $googleCalendars;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccountUser", mappedBy="account")
     */
    private $accounts;

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
    public function getGoogleTokens()
    {
        return $this->googleTokens;
    }

    public function setGoogleTokens(array $googleTokens): self
    {
        $this->googleTokens = $googleTokens;

        return $this;
    }

    public function addGoogleToken(GoogleAuthToken $googleTokens): self
    {
        $this->googleTokens[] = $googleTokens;

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

    /**
     * @return mixed
     */
    public function getOutlookTokens()
    {
        return $this->outlookTokens;
    }

    /**
     * @param mixed $outlookTokens
     */
    public function setOutlookTokens(array $outlookTokens): self
    {
        $this->outlookTokens = $outlookTokens;

        return $this;
    }

    public function addOutlookToken(OutlookAuthToken $googleTokens): self
    {
        $this->googleTokens[] = $googleTokens;

        return $this;
    }
}
