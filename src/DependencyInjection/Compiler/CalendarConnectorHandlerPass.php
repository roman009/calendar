<?php

namespace App\DependencyInjection\Compiler;

use App\Application\Services\Calendar\Connector\AbstractConnectorHandler;
use App\Application\Services\Calendar\Connector\ConnectorRegistry;
use App\Constants;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CalendarConnectorHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ConnectorRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(ConnectorRegistry::class);

        $taggedServices = $container->findTaggedServiceIds(Constants::TAG_CONNECTOR_HANDLER);

        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addConnectorHandler', [new Reference($id), $id::alias()]);
        }
    }
}