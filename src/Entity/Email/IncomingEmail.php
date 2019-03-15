<?php

namespace App\Entity\Email;

use App\Entity\BaseEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="from", nullable=false, type="string")
     */
    private $from;

    /**
     * @var string
     * @ORM\Column(name="to", nullable=false, type="string")
     */
    private $to;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", nullable=false, type="datetime")
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="message_id", nullable=false, type="string")
     */
    private $messageId;

    /**
     * @var string
     * @ORM\Column(name="body_html", nullable=false, type="text")
     */
    private $bodyHtml;

    /**
     * @var string
     * @ORM\Column(name="body_text", nullable=false, type="text")
     */
    private $bodyText;

    /**
     * @var ArrayCollection<IncomingEmailAttachment>
     * @ORM\OneToMany(targetEntity="IncomingEmailAttachment", mappedBy="incomingEmail", cascade={"persist"})
     */
    private $attachments;

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
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

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
    public function getBodyHtml(): string
    {
        return $this->bodyHtml;
    }

    /**
     * @param string $bodyHtml
     */
    public function setBodyHtml(string $bodyHtml): self
    {
        $this->bodyHtml = $bodyHtml;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyText(): string
    {
        return $this->bodyText;
    }

    /**
     * @param string $bodyText
     */
    public function setBodyText(string $bodyText): self
    {
        $this->bodyText = $bodyText;

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
