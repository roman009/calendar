<?php

namespace App;

use App\DependencyInjection\Compiler\CalendarConnectorAdapterPass;
use App\DependencyInjection\Compiler\CalendarCreateAdapterPass;
use App\DependencyInjection\Compiler\CalendarFetchAdapterPass;
use App\Service\Calendar\Connector\AbstractConnectorAdapter;
use App\Service\Calendar\Create\AbstractCreateAdapter;
use App\Service\Calendar\Fetch\AbstractFetchAdapter;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function build(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(AbstractConnectorAdapter::class)->addTag(Constants::TAG_CONNECTOR_ADAPTER);
        $container->registerForAutoconfiguration(AbstractFetchAdapter::class)->addTag(Constants::TAG_FETCH_ADAPTER);
        $container->registerForAutoconfiguration(AbstractCreateAdapter::class)->addTag(Constants::TAG_CREATE_ADAPTER);

        $container->addCompilerPass(new CalendarConnectorAdapterPass);
        $container->addCompilerPass(new CalendarFetchAdapterPass);
        $container->addCompilerPass(new CalendarCreateAdapterPass);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir() . '/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir() . '/config';

        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{packages}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routes->import($confDir . '/{routes}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob');
    }
}
