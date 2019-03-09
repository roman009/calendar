<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="GoogleAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleAuthToken extends AuthToken
{
    /**
     * @var string
     * @ORM\Column(name="scope", nullable=true, type="text")
     */
    private $scope;

    /**
     * @var string
     * @ORM\Column(name="json", nullable=true, type="text")
     */
    private $json;

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     * @return GoogleAuthToken
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
     * @return GoogleAuthToken
     */
    public function setJson(string $json): self
    {
        $this->json = $json;

        return $this;
    }
}
