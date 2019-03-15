<?php

namespace App\Entity\Email;

use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Email\AttachmentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class IncomingEmailAttachment
{
    use BaseEntityTrait;

    /**
     * @var string
     * @ORM\Column(name="name", nullable=false, type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="body", nullable=false, type="text")
     */
    private $body;

    /**
     * @var IncomingEmail
     * @ORM\ManyToOne(targetEntity="IncomingEmail")
     * @ORM\JoinColumn(fieldName="incoming_email_id", nullable=false, referencedColumnName="id")
     */
    private $incomingEmail;

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
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return IncomingEmail
     */
    public function getIncomingEmail(): IncomingEmail
    {
        return $this->incomingEmail;
    }

    /**
     * @param IncomingEmail $incomingEmail
     */
    public function setIncomingEmail(IncomingEmail $incomingEmail): self
    {
        $this->incomingEmail = $incomingEmail;

        return $this;
    }
}
