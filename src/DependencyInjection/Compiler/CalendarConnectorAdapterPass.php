<?php

namespace App\DependencyInjection\Compiler;

use App\Service\Calendar\Connector\ConnectorAdapterRegistry;
use App\Constants;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CalendarConnectorAdapterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ConnectorAdapterRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(ConnectorAdapterRegistry::class);

        $taggedServices = $container->findTaggedServiceIds(Constants::TAG_CONNECTOR_ADAPTER);

        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addConnectorAdapter', [new Reference($id), $id::alias()]);
        }
    }
}
