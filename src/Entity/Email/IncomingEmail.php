<?php

namespace App\Entity\Email;

use App\Entity\BaseEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Email\IncomingEmailRepository")
 * @ORM\HasLifecycleCallbacks
 */
class IncomingEmail
{
    use BaseEntityTrait;

    /**
     * @var string
     * @ORM\Column(name="subject", nullable=false, type="string")
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="email_from", nullable=false, type="string")
     */
    private $emailFrom;

    /**
     * @var string
     * @ORM\Column(name="email_to", nullable=false, type="string")
     */
    private $emailTo;

    /**
     * @var \DateTime
     * @ORM\Column(name="email_date", nullable=false, type="datetime")
     */
    private $emailDate;

    /**
     * @var string
     * @ORM\Column(name="message_id", nullable=false, type="string")
     */
    private $messageId;

    /**
     * @var string
     * @ORM\Column(name="body_html", nullable=true, type="text")
     */
    private $bodyHtml;

    /**
     * @var string
     * @ORM\Column(name="body_text", nullable=true, type="text")
     */
    private $bodyText;

    /**
     * @var ArrayCollection<IncomingEmailAttachment>
     * @ORM\OneToMany(targetEntity="IncomingEmailAttachment", mappedBy="incomingEmail", cascade={"persist"})
     */
    private $attachments;

    public function __construct()
    {
        $this->attachments = new ArrayCollection;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailFrom(): string
    {
        return $this->emailFrom;
    }

    /**
     * @param string $emailFrom
     */
    public function setEmailFrom(string $emailFrom): self
    {
        $this->emailFrom = $emailFrom;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailTo(): string
    {
        return $this->emailTo;
    }

    /**
     * @param string $emailTo
     */
    public function setEmailTo(string $emailTo): self
    {
        $this->emailTo = $emailTo;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEmailDate(): \DateTime
    {
        return $this->emailDate;
    }

    /**
     * @param \DateTime $emailDate
     */
    public function setEmailDate(\DateTime $emailDate): self
    {
        $this->emailDate = $emailDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     */
    public function setMessageId(string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyHtml(): ?string
    {
        return $this->bodyHtml;
    }

    /**
     * @param string $bodyHtml
     */
    public function setBodyHtml(?string $bodyHtml): self
    {
        $this->bodyHtml = $bodyHtml;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyText(): ?string
    {
        return $this->bodyText;
    }

    /**
     * @param string $bodyText
     */
    public function setBodyText(?string $bodyText): self
    {
        $this->bodyText = $bodyText;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    /**
     * @param Collection $attachments
     */
    public function setAttachments(Collection $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param IncomingEmailAttachment $attachment
     *
     * @return IncomingEmail
     */
    public function addAttachment(IncomingEmailAttachment $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }
}
