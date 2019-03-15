<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\SmartInviteEventRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class SmartInviteEvent
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var SmartInvite
     * @ORM\OneToOne(targetEntity="SmartInvite", inversedBy="event")
     * @ORM\JoinColumn(fieldName="smart_invite_id", nullable=false, referencedColumnName="id")
     */
    private $smartInvite;

    /**
     * @var string
     * @ORM\Column(name="summary", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group", "default_callback_response_group"})
     */
    private $summary;

    /**
     * @var string
     * @ORM\Column(name="description", nullable=true, type="text")
     * @Groups({"default_api_response_group", "default_api_write_group", "default_callback_response_group"})
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="start", nullable=false, type="datetime")
     * @Groups({"default_api_response_group", "default_api_write_group", "default_callback_response_group"})
     */
    private $start;

    /**
     * @var \DateTime
     * @ORM\Column(name="end", nullable=false, type="datetime")
     * @Groups({"default_api_response_group", "default_api_write_group", "default_callback_response_group"})
     */
    private $end;

    /**
     * @var string
     * @ORM\Column(name="timezone", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group", "default_callback_response_group"})
     */
    private $timezone;

    /**
     * @var string
     * @ORM\Column(name="location", nullable=true, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group", "default_callback_response_group"})
     */
    private $location;

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

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart(\DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd(\DateTime $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
