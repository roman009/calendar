<?php

namespace App\DependencyInjection\Compiler;

use App\Application\Services\Calendar\Create\CreateAdapterRegistry;
use App\Constants;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CalendarCreateAdapterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(CreateAdapterRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(CreateAdapterRegistry::class);

        $taggedServices = $container->findTaggedServiceIds(Constants::TAG_CREATE_ADAPTER);

        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addCreateAdapter', [new Reference($id), $id::alias()]);
        }
    }
}
