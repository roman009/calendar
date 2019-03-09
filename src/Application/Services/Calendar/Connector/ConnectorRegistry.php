<?php

namespace App\Application\Services\Calendar\Connector;

class ConnectorRegistry
{
    private $connectors;

    public function __construct()
    {
        $this->connectors = [];
    }

    public function addConnectorHandler(AbstractConnectorHandler $connector, string $alias)
    {
        $this->connectors[$alias] = $connector;
    }

    public function getConnectorHandler(string $alias): AbstractConnectorHandler
    {
        if (array_key_exists($alias, $this->connectors)) {
            return $this->connectors[$alias];
        }

        throw new \Exception('Undefined connector: ' . $alias);
    }
}