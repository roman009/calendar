<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\AttachmentRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Attachment
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var SmartInvite
     * @ORM\ManyToOne(targetEntity="SmartInvite")
     * @ORM\JoinColumn(fieldName="smart_invite_id", nullable=false, referencedColumnName="id")
     */
    private $smartInvite;

    /**
     * @var string
     * @ORM\Column(name="icalendar", nullable=false, type="text")
     * @Groups({"default_api_response_group"})
     */
    private $icalendar;
}
