<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Entity\Service;

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

    public function getFetchAdapter(Service $service): AbstractFetchAdapter
    {
        if (array_key_exists($service->getCode(), $this->fetchAdapter)) {
            return $this->fetchAdapter[$service->getCode()];
        }

        throw new \Exception('Undefined fetch adapter: ' . $service->getCode());
    }
}
