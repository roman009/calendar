<?php

namespace App\Application\Services\Calendar\Fetch;

class FetchRegistry
{
    private $fetchHandler;

    public function __construct()
    {
        $this->fetchHandler = [];
    }

    public function addFetchHandler(AbstractFetchHandler $connector, string $alias)
    {
        $this->fetchHandler[$alias] = $connector;
    }

    public function getFetchHandler(string $alias): AbstractFetchHandler
    {
        if (array_key_exists($alias, $this->fetchHandler)) {
            return $this->fetchHandler[$alias];
        }

        throw new \Exception('Undefined fetch handler: ' . $alias);
    }
}