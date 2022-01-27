<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Persistence;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesInterface;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\ManifestReference;

interface PersistentVolumeClaimInterface extends ManifestInterface
{
    /**
     * @return AccessMode[]
     */
    public function accessModes(): iterable;
    public function dataSource(): ManifestReference|null;
    public function resources(ContainerResourcesInterface $resources): void;
    public function selector(SelectorConfigurator $selector): void;
    public function storageClassName(): string|null;
    public function volumeMode(): VolumeMode;
    public function volumeName(): string|null;
}
