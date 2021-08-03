<?php

namespace Dealroadshow\K8S\Framework\Core\Persistence;

use Dealroadshow\K8S\API\PersistentVolume;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesInterface;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestReference;

abstract class AbstractPersistentVolumeClaim implements PersistentVolumeClaimInterface
{
    public function dataSource(): ManifestReference|null
    {
        return null;
    }

    public function resources(ContainerResourcesInterface $resources): void
    {
    }

    public function selector(SelectorConfigurator $selector): void
    {
    }

    public function storageClassName(): string
    {
        return "";
    }

    public function volumeMode(): VolumeMode
    {
        return VolumeMode::filesystem();
    }

    public static function kind(): string
    {
        return PersistentVolume::KIND;
    }
}