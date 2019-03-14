<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
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
     * @var Recipient
     * @ORM\OneToOne(targetEntity="Recipient")
     * @ORM\JoinColumn(fieldName="recipient_id", nullable=false, referencedColumnName="id")
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
     * @var Event
     * @ORM\OneToOne(targetEntity="Event")
     * @ORM\JoinColumn(fieldName="event_id", nullable=false, referencedColumnName="id")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $event;

    /**
     * @var Organizer
     * @ORM\OneToOne(targetEntity="Organizer")
     * @ORM\JoinColumn(fieldName="organizer_id", nullable=false, referencedColumnName="id")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $organizer;

    /**
     * @var array<Attachment>
     * @ORM\OneToMany(targetEntity="Attachment")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $attachments;
}
