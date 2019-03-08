<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleToken
{
    use BaseEntityTrait;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="googleToken")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="access_token", nullable=false, type="string")
     */
    private $accessToken;

    /**
     * @var string
     * @ORM\Column(name="refresh_token", nullable=false, type="string")
     */
    private $refreshToken;

    /**
     * @var string
     * @ORM\Column(name="scope", nullable=false, type="text")
     */
    private $scope;

    /**
     * @var integer
     * @ORM\Column(name="expires_in", nullable=false, type="integer")
     */
    private $expiresIn;

    /**
     * @var string
     * @ORM\Column(name="json", nullable=false, type="text")
     */
    private $json;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
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
     */
    public function setExpiresIn(int $expiresIn): self
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * @return string
     */
    public function getJson(): string
    {
        return $this->json;
    }

    /**
     * @param string $json
     */
    public function setJson(string $json): self
    {
        $this->json = $json;

        return $this;
    }

}
