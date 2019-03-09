<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AuthToken
{
    use BaseEntityTrait;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="googleToken")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(name="access_token", nullable=false, type="string")
     */
    protected $accessToken;

    /**
     * @var string
     * @ORM\Column(name="refresh_token", nullable=false, type="string")
     */
    protected $refreshToken;

    /**
     * @var integer
     * @ORM\Column(name="expires_in", nullable=false, type="integer")
     */
    protected $expiresIn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     * @return AuthToken
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     * @return AuthToken
     */
    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     * @return AuthToken
     */
    public function setExpiresIn(int $expiresIn): self
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }

}