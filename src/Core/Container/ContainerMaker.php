<?php

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
use Dealroadshow\K8S\Framework\Middleware\ContainerImageMiddlewareInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

class ContainerMaker implements ContainerMakerInterface
{
    /**
     * @param AppRegistry                         $appRegistry
     * @param ManifestManager                     $manifestManager
     * @param ContainerImageMiddlewareInterface[] $middlewares
     */
    public function __construct(private AppRegistry $appRegistry, private ManifestManager $manifestManager, private iterable $middlewares)
    {
    }

    public function make(ContainerInterface $manifest, VolumeList $volumes, AppInterface $app): Container
    {
        $container = new Container($manifest->containerName());

        $manifest->args($container->args());
        $manifest->command($container->command());

        $env = new EnvConfigurator(
            $container->env(),
            $container->envFrom(),
            $app,
            $this->appRegistry,
            $this->manifestManager
        );
        $manifest->env($env);

        $mounts = new VolumeMountsConfigurator($volumes, $container->volumeMounts());
        $manifest->volumeMounts($mounts);

        $resources = new ResourcesConfigurator($container->resources());
        $manifest->resources($resources);

        $ports = new PortsConfigurator($container->ports());
        $manifest->ports($ports);

        $lifecycle = new LifecycleConfigurator($container->lifecycle());
        $manifest->lifecycle($lifecycle);

        $probes = new ProbesConfigurator(
            $container->livenessProbe(),
            $container->readinessProbe(),
            $container->startupProbe()
        );
        $manifest->probes($probes);

        $image = $manifest->image();
        $this->applyMiddlewares($image, $app);
        $container->setImage($image->fullName());
        $pullPolicy = $manifest->imagePullPolicy();
        if (null !== $pullPolicy) {
            $container->setImagePullPolicy($pullPolicy->toString());
        }

        $workingDir = $manifest->workingDir();
        if (null !== $workingDir) {
            $container->setWorkingDir($workingDir);
        }

        $securityContext = new SecurityContextConfigurator($container->securityContext());
        $manifest->securityContext($securityContext);

        $manifest->configureContainer($container);

        return $container;
    }

    private function applyMiddlewares(Image $image, AppInterface $app)
    {
        foreach ($this->middlewares as $middleware) {
            $middleware->apply($image, $app);
        }
    }
}
