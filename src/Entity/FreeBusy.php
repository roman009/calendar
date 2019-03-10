<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

abstract class FreeBusy
{
    use BaseEntityTrait;

    public const TYPE_BUSY = 'busy';
    public const TYPE_FREE = 'free';

    /**
     * @var string
     * @Groups({"default_api_response_group"})
     */
    protected $calendar;

    /**
     * @var \DateTime
     * @Groups({"default_api_response_group"})
     */
    protected $start;

    /**
     * @var \DateTime
     * @Groups({"default_api_response_group"})
     */
    protected $end;

    /**
     * @var string
     * @Groups({"default_api_response_group"})
     */
    protected $type;

    /**
     * @return string
     */
    public function getCalendar(): string
    {
        return $this->calendar;
    }

    /**
     * @param string $calendar
     */
    public function setCalendar(string $calendar): self
    {
        $this->calendar = $calendar;

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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
