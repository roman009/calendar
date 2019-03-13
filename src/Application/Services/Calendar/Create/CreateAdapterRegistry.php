<?php

namespace App\Application\Services\Calendar\Create;

class CreateAdapterRegistry
{
    private $createAdapter;

    public function __construct()
    {
        $this->createAdapter = [];
    }

    public function addFetchAdapter(AbstractCreateAdapter $adapter, string $alias)
    {
        $this->createAdapter[$alias] = $adapter;
    }

    public function getCreateAdapter(string $alias): AbstractCreateAdapter
    {
        if (array_key_exists($alias, $this->createAdapter)) {
            return $this->createAdapter[$alias];
        }

        throw new \Exception('Undefined create adapter: ' . $alias);
    }
}