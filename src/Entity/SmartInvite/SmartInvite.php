<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\SmartInviteRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class SmartInvite
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var SmartInviteRecipient
     * @ORM\OneToOne(targetEntity="SmartInviteRecipient", mappedBy="smartInvite", cascade={"persist"})
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $recipient;

    /**
     * @var string
     * @ORM\Column(name="smart_invite_id", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $smartInviteId;

    /**
     * @var string
     * @ORM\Column(name="callback_url", nullable=true, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $callbackUrl;

    /**
     * @var SmartInviteEvent
     * @ORM\OneToOne(targetEntity="SmartInviteEvent", mappedBy="smartInvite", cascade={"persist"})
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $event;

    /**
     * @var SmartInviteOrganizer
     * @ORM\OneToOne(targetEntity="SmartInviteOrganizer", mappedBy="smartInvite", cascade={"persist"})
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $organizer;

    /**
     * @var ArrayCollection<SmartInviteAttachment>
     * @ORM\OneToMany(targetEntity="SmartInviteAttachment", mappedBy="smartInvite", cascade={"persist"})
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $attachments;

    public function __construct()
    {
        $this->attachments = new ArrayCollection;
    }

    /**
     * @return SmartInviteRecipient
     */
    public function getRecipient(): SmartInviteRecipient
    {
        return $this->recipient;
    }

    /**
     * @param SmartInviteRecipient $recipient
     */
    public function setRecipient(SmartInviteRecipient $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return string
     */
    public function getSmartInviteId(): string
    {
        return $this->smartInviteId;
    }

    /**
     * @param string $smartInviteId
     */
    public function setSmartInviteId(string $smartInviteId): self
    {
        $this->smartInviteId = $smartInviteId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    /**
     * @param string $callbackUrl
     */
    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }

    /**
     * @return SmartInviteEvent
     */
    public function getEvent(): SmartInviteEvent
    {
        return $this->event;
    }

    /**
     * @param SmartInviteEvent $event
     */
    public function setEvent(SmartInviteEvent $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return SmartInviteOrganizer
     */
    public function getOrganizer(): SmartInviteOrganizer
    {
        return $this->organizer;
    }

    /**
     * @param SmartInviteOrganizer $organizer
     */
    public function setOrganizer(SmartInviteOrganizer $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAttachments(): ArrayCollection
    {
        return $this->attachments;
    }

    /**
     * @param ArrayCollection $attachments
     */
    public function setAttachments(ArrayCollection $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }
}
