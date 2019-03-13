<?php

namespace App\Application\Services\Calendar\Create;

use App\Entity\AuthToken;
use App\Entity\Calendar;

class Create
{
    /**
     * @var CreateAdapterRegistry
     */
    private $createRegistry;

    public function __construct(CreateAdapterRegistry $createAdapterRegistry)
    {
        $this->createRegistry = $createAdapterRegistry;
    }

    /**
     * @param string $service
     * @param AuthToken $token
     *
     * @param string $calendarName
     * @return Calendar
     * @throws \Exception
     */
    public function createCalendar(string $service, AuthToken $token, string $calendarName): Calendar
    {
        $handler = $this->createRegistry->getCreateAdapter($service);

        return $handler->createCalendar($token, $calendarName);
    }
}