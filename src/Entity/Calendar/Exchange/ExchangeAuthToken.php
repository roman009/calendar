<?php

namespace App\Entity\Calendar\Exchange;

use App\Entity\Calendar\AuthToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ExchangeAuthToken extends AuthToken
{
    use ExchangeProviderTrait;

    /**
     * @var string
     * @ORM\Column(name="access_token", nullable=true, type="text")
     */
    protected $accessToken;

    /**
     * @var string
     * @ORM\Column(name="refresh_token", nullable=true, type="text")
     */
    protected $refreshToken;

    /**
     * @var integer
     * @ORM\Column(name="expires", nullable=true, type="integer")
     */
    protected $expires;

    /**
     * @var string
     * @ORM\Column(name="json", nullable=true, type="text")
     */
    protected $json;

    /**
     * @var string
     * @ORM\Column(name="username", nullable=false, type="string")
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(name="password", nullable=false, type="string")
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="server", nullable=false, type="string")
     */
    private $server;

    /**
     * @var string
     * @ORM\Column(name="version", nullable=false, type="string")
     */
    private $version;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

    /**
     * @param string $server
     */
    public function setServer(string $server): self
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }
}
