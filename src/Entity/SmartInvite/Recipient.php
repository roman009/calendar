<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\RecipientRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Recipient
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_TENTATIVE = 'tentative';

    /**
     * @var SmartInvite
     * @ORM\OneToOne(targetEntity="SmartInvite", inversedBy="recipient")
     * @ORM\JoinColumn(fieldName="smart_invite_id", nullable=false, referencedColumnName="id")
     */
    private $smartInvite;

    /**
     * @var string
     * @ORM\Column(name="email", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="status", nullable=false, type="string")
     * @Groups({"default_api_response_group"})
     */
    private $status;

    public function __construct()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return SmartInvite
     */
    public function getSmartInvite(): SmartInvite
    {
        return $this->smartInvite;
    }

    /**
     * @param SmartInvite $smartInvite
     */
    public function setSmartInvite(SmartInvite $smartInvite): self
    {
        $this->smartInvite = $smartInvite;

        return $this;
    }
}