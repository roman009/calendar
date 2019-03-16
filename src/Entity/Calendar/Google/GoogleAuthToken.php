<?php

namespace App\Entity\Calendar\Google;

use App\Entity\Calendar\AuthToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Google\GoogleAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleAuthToken extends AuthToken
{
    use GoogleProviderTrait;

    /**
     * @var string
     * @ORM\Column(name="scope", nullable=true, type="text")
     */
    private $scope;

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     *
     * @return GoogleAuthToken
     */
    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }
}
