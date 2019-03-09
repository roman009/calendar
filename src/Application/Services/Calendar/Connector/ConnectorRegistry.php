<?php

namespace App\Application\Services\Calendar\Connector;

class ConnectorRegistry
{
    private $connectorHandlers;

    public function __construct()
    {
        $this->connectorHandlers = [];
    }

    public function addConnectorHandler(AbstractConnectorHandler $connector, string $alias)
    {
        $this->connectorHandlers[$alias] = $connector;
    }

    public function getConnectorHandler(string $alias): AbstractConnectorHandler
    {
        if (array_key_exists($alias, $this->connectorHandlers)) {
            return $this->connectorHandlers[$alias];
        }

        throw new \Exception('Undefined connector: ' . $alias);
    }
}