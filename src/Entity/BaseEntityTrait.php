<?php

namespace App\Entity;

use App\Application\Services\Security\GenerateToken;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="public_id", nullable=false, type="string", length=32, unique=true)
     */
    protected $publicId;

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
        $this->publicId = (new GenerateToken)();
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
}
