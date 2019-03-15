<?php

namespace App\Services\Calendar\Connector;

use App\Entity\Service;

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

    public function getConnectorAdapter(Service $service): AbstractConnectorAdapter
    {
        if (array_key_exists($service->getCode(), $this->connectorAdapters)) {
            return $this->connectorAdapters[$service->getCode()];
        }

        throw new \Exception('Undefined connection adapter: ' . $service->getCode());
    }
}
