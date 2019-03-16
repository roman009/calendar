<?php

namespace App\Entity\Calendar\Office365;

use App\Entity\Calendar\Calendar;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Calendar\Office365\Office365CalendarRepository")
 * @ORM\Table(name="office365_calendar", indexes={@ORM\Index(columns={"account_user_id", "calendar_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Office365Calendar extends Calendar
{
    use Office365ProviderTrait;

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
     *
     * @return Office365Calendar
     */
    public function setOwnerEmailAddress(string $ownerEmailAddress): self
    {
        $this->ownerEmailAddress = $ownerEmailAddress;

        return $this;
    }
}
