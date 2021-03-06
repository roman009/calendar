<?php

namespace App\Entity;

use App\Service\Security\GenerateToken;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait BaseEntityTrait
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="object_id", nullable=false, type="string", length=32, unique=true)
     * @Groups({"default_api_response_group"})
     */
    protected $objectId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     *
     * @return self
     */
    public function setUpdated(\DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Gets triggered only on insert
     *
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime;
        $this->updated = new \DateTime;
        $this->objectId = (new GenerateToken)();
    }

    /**
     * Gets triggered every time on update

     *
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return self
     */
    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    /**
     * @param string $objectId
     *
     * @return self
     */
    public function setObjectId(string $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }
}
