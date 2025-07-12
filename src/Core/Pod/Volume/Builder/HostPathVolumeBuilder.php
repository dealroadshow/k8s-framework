<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder;

use Dealroadshow\K8S\Api\Core\V1\HostPathVolumeSource;
use Dealroadshow\K8S\Api\Core\V1\Volume;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\HostPathVolumeType;

class HostPathVolumeBuilder extends AbstractVolumeBuilder
{
    private HostPathVolumeSource $source;

    public function init(Volume $volume): void
    {
        $this->source = $volume->getHostPath();
    }

    public function setPath(string $path): self
    {
        $this->source->setPath($path);

        return $this;
    }

    public function setType(HostPathVolumeType $type): self
    {
        $this->source->setType($type->value);

        return $this;
    }
}
