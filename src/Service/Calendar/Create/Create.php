<?php

namespace App\Service\Calendar\Create;

use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\Service;

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
     * @param string $calendarName
     *
     * @throws \Exception
     *
     * @return Calendar
     */
    public function createCalendar(Service $service, AuthToken $token, string $calendarName): Calendar
    {
        $handler = $this->createRegistry->getCreateAdapter($service);

        return $handler->createCalendar($token, $calendarName);
    }
}
