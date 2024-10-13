<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Api\Core\V1\Container;
use Dealroadshow\K8S\Api\Core\V1\VolumeList;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\App\Integration\EnvSourcesRegistry;
use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Image\Image;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\LifecycleConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes\ProbesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Ports\PortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Security\SecurityContextConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\VolumeMount\VolumeMountsConfigurator;
use Dealroadshow\K8S\Framework\Event\ContainerGeneratedEvent;
use Dealroadshow\K8S\Framework\Middleware\ContainerImageMiddlewareInterface;
use Dealroadshow\K8S\Framework\Proxy\ProxyFactory;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\Proximity\ProxyInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

readonly class ContainerMaker implements ContainerMakerInterface
{
    /**
     * @param ContainerImageMiddlewareInterface[] $middlewares
     */
    public function __construct(
        private AppRegistry $appRegistry,
        private EventDispatcherInterface $dispatcher,
        private ProxyFactory $proxyFactory,
        private EnvSourcesRegistry $envSourcesRegistry,
        private iterable $middlewares
    ) {
    }

    public function make(ContainerInterface $builder, VolumeList $volumes, AppInterface $app): Container
    {
        if (!($builder instanceof ProxyInterface)) {
            $builder = $this->proxyFactory->makeProxy($builder);
        }

        $container = new Container($builder->containerName());

        $builder->args($container->args());
        $builder->command($container->command());

        $env = new EnvConfigurator(
            $container->env(),
            $container->envFrom(),
            $app,
            $this->appRegistry,
            $this->envSourcesRegistry
        );
        $builder->env($env);

        $mounts = new VolumeMountsConfigurator($volumes, $container->volumeMounts());
        $builder->volumeMounts($mounts);

        $resources = new ResourcesConfigurator($container->resources());
        $builder->resources($resources);

        $ports = new PortsConfigurator($container->ports());
        $builder->ports($ports);

        $lifecycle = new LifecycleConfigurator($container->lifecycle());
        $builder->lifecycle($lifecycle);

        $probes = new ProbesConfigurator(
            $container->livenessProbe(),
            $container->readinessProbe(),
            $container->startupProbe()
        );
        $builder->probes($probes);

        $image = $builder->image();
        $this->applyMiddlewares($image, $app);
        $container->setImage($image->fullName());
        $pullPolicy = $builder->imagePullPolicy();
        if (null !== $pullPolicy) {
            $container->setImagePullPolicy($pullPolicy->toString());
        }

        $workingDir = $builder->workingDir();
        if (null !== $workingDir) {
            $container->setWorkingDir($workingDir);
        }

        $securityContext = new SecurityContextConfigurator($container->securityContext());
        $builder->securityContext($securityContext);

        $builder->configureContainer($container);

        $this->dispatcher->dispatch(new ContainerGeneratedEvent($container, $builder), ContainerGeneratedEvent::NAME);

        return $container;
    }

    private function applyMiddlewares(Image $image, AppInterface $app): void
    {
        foreach ($this->middlewares as $middleware) {
            $middleware->apply($image, $app);
        }
    }
}
