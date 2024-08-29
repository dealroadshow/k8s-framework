<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod;

use Dealroadshow\K8S\Api\Core\V1\PodSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerMakerInterface;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\PriorityClass\PriorityClassConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Toleration\TolerationsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Topology\TopologySpreadConstraintsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;
use Dealroadshow\K8S\Framework\Event\PodSpecGeneratedEvent;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ClassName;
use Dealroadshow\K8S\Framework\Util\ManifestReferencesService;
use Psr\EventDispatcher\EventDispatcherInterface;

readonly class PodSpecProcessor
{
    public function __construct(
        private ContainerMakerInterface $containerMaker,
        private AppRegistry $appRegistry,
        private EventDispatcherInterface $dispatcher,
        private ManifestReferencesService $referencesService
    ) {
    }

    public function process(PodSpecInterface $builder, PodSpec $spec, AppInterface $app): void
    {
        $affinity = new AffinityConfigurator($spec->affinity());
        $builder->affinity($affinity);

        $volumes = new VolumesConfigurator($spec->volumes(), $app, $this->appRegistry);
        $builder->volumes($volumes);

        foreach ($builder->containers() as $containerBuilder) {
            $this->ensureValidContainerBuilder($containerBuilder);
            $container = $this->containerMaker->make($containerBuilder, $spec->volumes(), $app);
            $spec->containers()->add($container);
        }

        if (0 === $spec->containers()->count()) {
            throw new \LogicException(
                sprintf(
                    'No containers were returned from method %s::containers()',
                    ClassName::real($builder)
                )
            );
        }

        foreach ($builder->initContainers() as $containerBuilder) {
            $this->ensureValidContainerBuilder($containerBuilder);
            $container = $this->containerMaker->make($containerBuilder, $spec->volumes(), $app);
            $spec->initContainers()->add($container);
        }

        $imagePullSecrets = new ImagePullSecretsConfigurator($spec->imagePullSecrets(), $app);
        $builder->imagePullSecrets($imagePullSecrets);

        $builder->nodeSelector($spec->nodeSelector());

        $tolerations = new TolerationsConfigurator($spec->tolerations());
        $builder->tolerations($tolerations);

        $restartPolicy = $builder->restartPolicy();
        if (null !== $restartPolicy) {
            $spec->setRestartPolicy($restartPolicy->toString());
        }

        $priorityClass = new PriorityClassConfigurator(
            spec: $spec,
            app: $app,
            appRegistry: $this->appRegistry
        );
        $builder->priorityClass($priorityClass);

        $serviceAccountName = null;
        if ($serviceAccountReference = $builder->serviceAccount()) {
            $serviceAccountName = $this->referencesService->toResourceName($serviceAccountReference);
        }
        if (null !== $builder->serviceAccountName()) {
            $serviceAccountName = $builder->serviceAccountName();
        }
        if (null !== $serviceAccountName) {
            $spec->setServiceAccountName($serviceAccountName);
        }

        $constraints = new TopologySpreadConstraintsConfigurator($spec->topologySpreadConstraints());
        $builder->topologySpreadConstraints($constraints);

        $terminationGracePeriodSeconds = $builder->terminationGracePeriodSeconds();
        if (null !== $terminationGracePeriodSeconds) {
            $spec->setTerminationGracePeriodSeconds($terminationGracePeriodSeconds);
        }

        $builder->configurePodSpec($spec);

        $this->dispatcher->dispatch(new PodSpecGeneratedEvent($spec, $builder), PodSpecGeneratedEvent::NAME);
    }

    private function ensureValidContainerBuilder(mixed $builder): void
    {
        if (!$builder instanceof ContainerInterface) {
            throw new \TypeError(
                sprintf(
                    'All containers must be instances of "%s", "%s" given',
                    ContainerInterface::class,
                    get_debug_type($builder)
                )
            );
        }
    }
}
