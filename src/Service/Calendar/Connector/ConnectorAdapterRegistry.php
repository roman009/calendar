<?php

namespace App\Service\Calendar\Connector;

use App\Entity\Calendar\CalendarServiceProvider;

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

    public function getConnectorAdapter(CalendarServiceProvider $service): AbstractConnectorAdapter
    {
        if (array_key_exists($service->getCode(), $this->connectorAdapters)) {
            return $this->connectorAdapters[$service->getCode()];
        }

        throw new \Exception('Undefined connection adapter: ' . $service->getCode());
    }
}
