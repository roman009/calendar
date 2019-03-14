<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeCalendarRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "calendar_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class ExchangeCalendar extends Calendar
{
    use ExchangeProviderTrait;

    /**
     * @var string
     * @ORM\Column(name="change_key", nullable=true, type="string")
     */
    private $changeKey;

    public function setChangeKey(string $changeKey): self
    {
        $this->changeKey = $changeKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getChangeKey(): string
    {
        return $this->changeKey;
    }
}
