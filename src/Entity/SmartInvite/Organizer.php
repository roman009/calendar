<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\OrganizerRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Organizer
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var SmartInvite
     * @ORM\OneToOne(targetEntity="SmartInvite", inversedBy="organizer")
     * @ORM\JoinColumn(fieldName="smart_invite_id", nullable=false, referencedColumnName="id")
     */
    private $smartInvite;

    /**
     * @var string
     * @ORM\Column(name="name", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
