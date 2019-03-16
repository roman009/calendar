<?php

namespace App\Entity\Calendar;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;

abstract class Event
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $eventId;

    /**
     * @var string
     */
    private $creator;

    /**
     * @var string
     */
    private $organizer;

    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var string
     */
    private $timezone;

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
    public function getEventId(): string
    {
        return $this->eventId;
    }

    /**
     * @param string $eventId
     */
    public function setEventId(string $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreator(): string
    {
        return $this->creator;
    }

    /**
     * @param string $creator
     */
    public function setCreator(string $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizer(): string
    {
        return $this->organizer;
    }

    /**
     * @param string $organizer
     */
    public function setOrganizer(string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart(\DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd(\DateTime $end): self
    {
        $this->end = $end;

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
     */
    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }
}
