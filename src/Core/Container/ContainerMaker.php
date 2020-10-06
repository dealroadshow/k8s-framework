<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Data\Collection\VolumeList;
use Dealroadshow\K8S\Data\Container;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\LifecycleConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes\ProbesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Ports\PortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\Security\SecurityContextConfigurator;
use Dealroadshow\K8S\Framework\Core\Container\VolumeMount\VolumeMountsConfigurator;

class ContainerMaker
{
    public function make(ContainerInterface $builder, VolumeList $volumes, AppInterface $app): Container
    {
        $container = new Container($builder->name());

        $builder->args($container->args());
        $builder->command($container->command());

        $env = new EnvConfigurator($container->env(), $container->envFrom(), $app);
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

        $container->setImage($builder->image()->fullName());
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

        return $container;
    }
}
