<?php

namespace App\Application\Services\Calendar\Fetch;

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

    public function getFetchAdapter(string $alias): AbstractFetchAdapter
    {
        if (array_key_exists($alias, $this->fetchAdapter)) {
            return $this->fetchAdapter[$alias];
        }

        throw new \Exception('Undefined fetch adapter: ' . $alias);
    }
}
