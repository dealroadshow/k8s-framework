<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\PriorityClass\PriorityClassConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Toleration\TolerationsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Topology\TopologySpreadConstraintsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

abstract class AbstractDeployment extends AbstractManifest implements DeploymentInterface
{
    public function affinity(AffinityConfigurator $affinity): void
    {
    }

    public function initContainers(): iterable
    {
        return [];
    }

    public function imagePullSecrets(ImagePullSecretsConfigurator $secrets): void
    {
    }

    public function nodeSelector(StringMap $nodeSelector): void
    {
    }

    public function tolerations(TolerationsConfigurator $tolerations): void
    {
    }

    public function volumes(VolumesConfigurator $volumes): void
    {
    }

    public function restartPolicy(): RestartPolicy|null
    {
        return null;
    }

    public function configurePodSpec(PodSpec $spec): void
    {
    }

    public function replicas(): int
    {
        return 1;
    }

    public function selector(SelectorConfigurator $selector): void
    {
    }

    public function strategy(StrategyConfigurator $strategy): void
    {
    }

    public function minReadySeconds(): int|null
    {
        return null;
    }

    public function progressDeadlineSeconds(): int|null
    {
        return null;
    }

    public function priorityClass(PriorityClassConfigurator $priorityClass): void
    {
    }

    public function serviceAccountName(): string|null
    {
        return null;
    }

    public function serviceAccount(): ManifestReference|null
    {
        return null;
    }

    public function terminationGracePeriodSeconds(): int|null
    {
        return null;
    }

    public function topologySpreadConstraints(TopologySpreadConstraintsConfigurator $constraints): void
    {
    }

    public function configureDeployment(Deployment $deployment): void
    {
    }

    final public static function kind(): string
    {
        return Deployment::KIND;
    }

    final public static function apiVersion(): string
    {
        return Deployment::API_VERSION;
    }
}
