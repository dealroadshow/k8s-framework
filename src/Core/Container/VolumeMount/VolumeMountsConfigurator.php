<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\VolumeMount;

use Dealroadshow\K8S\Api\Core\V1\VolumeList;
use Dealroadshow\K8S\Api\Core\V1\VolumeMount;
use Dealroadshow\K8S\Api\Core\V1\VolumeMountList;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesMap;

class VolumeMountsConfigurator
{
    private VolumesMap $volumes;
    private VolumeMountList $mounts;

    public function __construct(VolumeList $volumes, VolumeMountList $mounts)
    {
        $this->volumes = VolumesMap::fromVolumeList($volumes);
        $this->mounts = $mounts;
    }

    public function add(string $volumeName, string $mountPath, bool $checkVolumeExistence = true): VolumeMountBuilder
    {
        if (!$this->volumes->has($volumeName) && $checkVolumeExistence) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Volume "%s" is not defined. Available volumes: %s',
                    $volumeName,
                    implode(', ', $this->volumes->names())
                )
            );
        }

        $vm = new VolumeMount($mountPath, $volumeName);
        $this->mounts->add($vm);

        return new VolumeMountBuilder($vm);
    }
}
