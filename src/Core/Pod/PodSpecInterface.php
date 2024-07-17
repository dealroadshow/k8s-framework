<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\PriorityClass\PriorityClassConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Toleration\TolerationsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Topology\TopologySpreadConstraintsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

interface PodSpecInterface
{
    /**
     * @return ContainerInterface[]
     */
    public function containers(): iterable;

    /**
     * @return ContainerInterface[]
     */
    public function initContainers(): iterable;

    public function affinity(AffinityConfigurator $affinity): void;
    public function imagePullSecrets(ImagePullSecretsConfigurator $secrets): void;
    public function nodeSelector(StringMap $nodeSelector): void;
    public function tolerations(TolerationsConfigurator $tolerations): void;
    public function volumes(VolumesConfigurator $volumes): void;
    public function restartPolicy(): RestartPolicy|null;
    public function configurePodSpec(PodSpec $spec): void;
    public function priorityClass(PriorityClassConfigurator $priorityClass): void;
    public function serviceAccountName(): string|null;
    public function serviceAccount(): ManifestReference|null;
    public function terminationGracePeriodSeconds(): int|null;
    public function topologySpreadConstraints(TopologySpreadConstraintsConfigurator $constraints): void;
}
