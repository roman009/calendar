<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoogleAuthTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GoogleAuthToken extends AuthToken
{
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="googleTokens")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;

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
