<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\StatefulSet;

use Dealroadshow\K8S\API\Apps\StatefulSet;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\PriorityClass\PriorityClassConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;
use Dealroadshow\K8S\Framework\Core\StatefulSet\UpdateStrategy\UpdateStrategyConfigurator;

abstract class AbstractStatefulSet extends AbstractManifest implements StatefulSetInterface
{
    public static function kind(): string
    {
        return StatefulSet::KIND;
    }

    public function initContainers(): iterable
    {
        return [];
    }

    public function affinity(AffinityConfigurator $affinity): void
    {
    }

    public function imagePullSecrets(ImagePullSecretsConfigurator $secrets): void
    {
    }

    public function nodeSelector(StringMap $nodeSelector): void
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

    public function priorityClass(PriorityClassConfigurator $priorityClass): void
    {
    }

    public function podManagementPolicy(): PodManagementPolicy|null
    {
        return null;
    }

    public function replicas(): int
    {
        return 1;
    }

    public function revisionHistoryLimit(): int
    {
        return 10;
    }

    public function selector(SelectorConfigurator $selector): void
    {
    }

    public function updateStrategy(UpdateStrategyConfigurator $updateStrategy): void
    {
    }

    public function volumeClaimTemplates(): iterable
    {
        return [];
    }

    public function serviceAccountName(): string|null
    {
        return null;
    }

    public function serviceAccount(): ManifestReference|null
    {
        return null;
    }

    public function configureStatefulSet(StatefulSet $statefulSet): void
    {
    }
}
