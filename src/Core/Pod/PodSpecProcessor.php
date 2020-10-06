<?php

namespace Dealroadshow\K8S\Framework\Core\Pod;

use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerMaker;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Containers\PodContainers;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

class PodSpecProcessor
{
    private ContainerMaker $containerMaker;

    public function __construct(ContainerMaker $containerMaker)
    {
        $this->containerMaker = $containerMaker;
    }

    public function process(PodSpecInterface $builder, PodSpec $spec, AppInterface $app): void
    {
        $affinity = new AffinityConfigurator($spec->affinity());
        $builder->affinity($affinity);

        $volumes = new VolumesConfigurator($spec->volumes(), $app);
        $builder->volumes($volumes);

        $containerBuilders = new \ArrayObject();
        $builder->containers(new PodContainers($containerBuilders));
        if (0 === $containerBuilders->count()) {
            throw new \LogicException(
                sprintf(
                    'No containers added in %s::defineContainers() method',
                    get_class($builder)
                )
            );
        }
        foreach ($containerBuilders as $containerBuilder) {
            $container = $this->containerMaker->make($containerBuilder, $spec->volumes(), $app);
            $spec->containers()->add($container);
        }

        $containerBuilders = new \ArrayObject();
        $builder->initContainers(new PodContainers($containerBuilders));
        foreach ($containerBuilders as $containerBuilder) {
            $container = $this->containerMaker->make($containerBuilder, $spec->volumes(), $app);
            $spec->initContainers()->add($container);
        }

        $imagePullSecrets = new ImagePullSecretsConfigurator($spec->imagePullSecrets(), $app);
        $builder->imagePullSecrets($imagePullSecrets);

        $builder->nodeSelector($spec->nodeSelector());

        $restartPolicy = $builder->restartPolicy();
        if (null !== $restartPolicy) {
            $spec->setRestartPolicy($restartPolicy->toString());
        }

        $builder->configurePodSpec($spec);
    }
}
