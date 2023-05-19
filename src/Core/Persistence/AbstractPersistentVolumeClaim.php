<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Persistence;

use Dealroadshow\K8S\API\PersistentVolume;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesInterface;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestReference;

abstract class AbstractPersistentVolumeClaim extends AbstractManifest implements PersistentVolumeClaimInterface
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

    public function storageClassName(): string|null
    {
        return null;
    }

    public function volumeMode(): VolumeMode
    {
        return VolumeMode::filesystem();
    }

    public function volumeName(): string|null
    {
        return null;
    }

    public static function kind(): string
    {
        return PersistentVolume::KIND;
    }
}
