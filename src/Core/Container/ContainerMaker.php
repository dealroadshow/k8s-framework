<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Data\Collection\VolumeList;
use Dealroadshow\K8S\Data\Container;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Image\Image;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\LifecycleConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes\ProbesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Ports\PortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Security\SecurityContextConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\VolumeMount\VolumeMountsConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestManager;
use Dealroadshow\K8S\Framework\Event\ContainerGeneratedEvent;
use Dealroadshow\K8S\Framework\Middleware\ContainerImageMiddlewareInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;

class ContainerMaker implements ContainerMakerInterface
{
    /**
     * @param AppRegistry $appRegistry
     * @param ManifestManager $manifestManager
     * @param EventDispatcherInterface $dispatcher
     * @param ContainerImageMiddlewareInterface[] $middlewares
     */
    public function __construct(private AppRegistry $appRegistry, private ManifestManager $manifestManager, private EventDispatcherInterface $dispatcher, private iterable $middlewares)
    {
    }

    public function make(ContainerInterface $builder, VolumeList $volumes, AppInterface $app): Container
    {
        $container = new Container($builder->containerName());

        $builder->args($container->args());
        $builder->command($container->command());

        $env = new EnvConfigurator(
            $container->env(),
            $container->envFrom(),
            $app,
            $this->appRegistry,
            $this->manifestManager
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
