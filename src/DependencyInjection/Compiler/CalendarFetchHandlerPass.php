<?php

namespace App\DependencyInjection\Compiler;

use App\Application\Services\Calendar\Fetch\FetchRegistry;
use App\Constants;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CalendarFetchHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(FetchRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(FetchRegistry::class);

        $taggedServices = $container->findTaggedServiceIds(Constants::TAG_FETCH_HANDLER);

        foreach ($taggedServices as $id => $service) {
            $definition->addMethodCall('addFetchHandler', [new Reference($id), $id::alias()]);
        }
    }
}
