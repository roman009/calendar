<?php

namespace App\Entity\Calendar;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use App\Entity\Calendar\Google\GoogleAuthToken;
use Doctrine\ORM\Mapping as ORM;

abstract class AuthToken
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var string
     * @ORM\Column(name="access_token", nullable=false, type="text")
     */
    protected $accessToken;

    /**
     * @var string
     * @ORM\Column(name="refresh_token", nullable=false, type="text")
     */
    protected $refreshToken;

    /**
     * @var integer
     * @ORM\Column(name="expires", nullable=false, type="integer")
     */
    protected $expires;

    /**
     * @var string
     * @ORM\Column(name="json", nullable=true, type="text")
     */
    protected $json;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
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
     *
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
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * @param int $expires
     *
     * @return AuthToken
     */
    public function setExpires(int $expires): self
    {
        $this->expires = $expires;

        return $this;
    }

    public function hasExpired(): bool
    {
        $expires = $this->getExpires();

        if (empty($expires)) {
            throw new \RuntimeException('"expires" is not set on the token');
        }

        return $expires < time();
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
     *
     * @return GoogleAuthToken
     */
    public function setJson(string $json): self
    {
        $this->json = $json;

        return $this;
    }
}
