<?php

namespace App\Service\Calendar\Create;

use App\Entity\Calendar\CalendarServiceProvider;

class CreateAdapterRegistry
{
    private $createAdapters;

    public function __construct()
    {
        $this->createAdapters = [];
    }

    public function addCreateAdapter(AbstractCreateAdapter $adapter, string $alias)
    {
        $this->createAdapters[$alias] = $adapter;
    }

    public function getCreateAdapter(CalendarServiceProvider $service): AbstractCreateAdapter
    {
        if (array_key_exists($service->getCode(), $this->createAdapters)) {
            return $this->createAdapters[$service->getCode()];
        }

        throw new \Exception('Undefined create adapter: ' . $service->getCode());
    }
}
