<?php

namespace App\Entity\SmartInvite;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\EventRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Event
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var SmartInvite
     * @ORM\OneToOne(targetEntity="SmartInvite")
     * @ORM\JoinColumn(fieldName="smart_invite_id", nullable=false, referencedColumnName="id")
     */
    private $smartInvite;

    /**
     * @var string
     * @ORM\Column(name="summary", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $summary;

    /**
     * @var string
     * @ORM\Column(name="description", nullable=true, type="text")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="start", nullable=false, type="datetime")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $start;

    /**
     * @var \DateTime
     * @ORM\Column(name="end", nullable=false, type="datetime")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $end;

    /**
     * @var string
     * @ORM\Column(name="timezone", nullable=false, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $timezone;

    /**
     * @var string
     * @ORM\Column(name="location", nullable=true, type="string")
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    private $location;
}
