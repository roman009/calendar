<?php

namespace App\Entity;

use App\Application\Services\Security\GenerateToken;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

abstract class Calendar
{
    use BaseEntityTrait;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="googleCalendars")
     * @ORM\JoinColumn(fieldName="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;

    /**
     * @var bool
     * @ORM\Column(name="`primary`", nullable=false, type="boolean", options={"default"=false})
     * @Groups({"default_api_response_group"})
     */
    protected $primary;

    /**
     * @var string
     * @ORM\Column(name="calendar_id", nullable=true, type="string")
     */
    protected $calendarId;

    /**
     * @var string
     * @ORM\Column(name="description", nullable=true, type="text")
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(name="summary", nullable=true, type="text")
     * @Groups({"default_api_response_group"})
     */
    protected $summary;

    /**
     * @var string
     * @ORM\Column(name="timezone", nullable=true, type="string")
     */
    protected $timezone;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return GoogleCalendar
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->primary;
    }

    /**
     * @param bool $primary
     *
     * @return Calendar
     */
    public function setPrimary(bool $primary): self
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarId(): string
    {
        return $this->calendarId;
    }

    /**
     * @param string $calendarId
     *
     * @return Calendar
     */
    public function setCalendarId(string $calendarId): self
    {
        $this->calendarId = $calendarId;

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
     *
     * @return Calendar
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     *
     * @return Calendar
     */
    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

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
     *
     * @return Calendar
     */
    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicId(): string
    {
        return $this->publicId;
    }

    /**
     * @param string $publicId
     *
     * @return Calendar
     */
    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }
}
