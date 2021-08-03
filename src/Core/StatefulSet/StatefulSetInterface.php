<?php

namespace Dealroadshow\K8S\Framework\Core\StatefulSet;

use Dealroadshow\K8S\API\Apps\StatefulSet;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Core\Persistence\PersistentVolumeClaimInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;
use Dealroadshow\K8S\Framework\Core\StatefulSet\UpdateStrategy\UpdateStrategyConfigurator;

interface StatefulSetInterface extends PodTemplateSpecInterface, ManifestInterface
{
    public function podManagementPolicy(): PodManagementPolicy|null;
    public function replicas(): int;
    public function revisionHistoryLimit(): int;
    public function selector(SelectorConfigurator $selector): void;
    public function serviceName(): ManifestReference;
    public function updateStrategy(UpdateStrategyConfigurator $updateStrategy): void;

    /**
     * @return PersistentVolumeClaimInterface[]
     */
    public function volumeClaimTemplates(): iterable;

    public function configureStatefulSet(StatefulSet $statefulSet): void;
}
