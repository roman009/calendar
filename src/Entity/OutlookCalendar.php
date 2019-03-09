<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutlookCalendarRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"user_id", "calendar_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class OutlookCalendar extends Calendar
{
    /**
     * @var string
     * @ORM\Column(name="owner_email_address", nullable=true, type="string")
     */
    private $ownerEmailAddress;

    /**
     * @return string
     */
    public function getOwnerEmailAddress(): string
    {
        return $this->ownerEmailAddress;
    }

    /**
     * @param string $ownerEmailAddress
     * @return OutlookCalendar
     */
    public function setOwnerEmailAddress(string $ownerEmailAddress): self
    {
        $this->ownerEmailAddress = $ownerEmailAddress;

        return $this;
    }
}
