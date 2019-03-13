<?php

namespace App\Application\Services\Calendar\Connector;

class ConnectorAdapterRegistry
{
    private $connectorAdapters;

    public function __construct()
    {
        $this->connectorAdapters = [];
    }

    public function addConnectorAdapter(AbstractConnectorAdapter $adapter, string $alias)
    {
        $this->connectorAdapters[$alias] = $adapter;
    }

    public function getConnectorAdapter(string $alias): AbstractConnectorAdapter
    {
        if (array_key_exists($alias, $this->connectorAdapters)) {
            return $this->connectorAdapters[$alias];
        }

        throw new \Exception('Undefined connection adapter: ' . $alias);
    }
}
