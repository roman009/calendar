<?php

namespace App\Service\Calendar\Fetch;

use App\Entity\Calendar\CalendarServiceProvider;

class FetchAdapterRegistry
{
    private $fetchAdapter;

    public function __construct()
    {
        $this->fetchAdapter = [];
    }

    public function addFetchAdapter(AbstractFetchAdapter $adapter, string $alias)
    {
        $this->fetchAdapter[$alias] = $adapter;
    }

    public function getFetchAdapter(CalendarServiceProvider $service): AbstractFetchAdapter
    {
        if (array_key_exists($service->getCode(), $this->fetchAdapter)) {
            return $this->fetchAdapter[$service->getCode()];
        }

        throw new \Exception('Undefined fetch adapter: ' . $service->getCode());
    }
}
