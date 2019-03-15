<?php

namespace App\DependencyInjection\Compiler;

use App\Services\Calendar\Fetch\FetchAdapterRegistry;
use App\Constants;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CalendarFetchAdapterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(FetchAdapterRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(FetchAdapterRegistry::class);

        $taggedServices = $container->findTaggedServiceIds(Constants::TAG_FETCH_ADAPTER);

        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addFetchAdapter', [new Reference($id), $id::alias()]);
        }
    }
}
