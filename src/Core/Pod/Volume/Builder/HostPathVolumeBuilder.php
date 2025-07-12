<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder;

use Dealroadshow\K8S\Api\Core\V1\HostPathVolumeSource;
use Dealroadshow\K8S\Api\Core\V1\Volume;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\HostPathVolumeType;

class HostPathVolumeBuilder extends AbstractVolumeBuilder
{
    private HostPathVolumeSource $source;

    public function __construct(string $path)
    {
        $this->source = new HostPathVolumeSource($path);
    }

    public function init(Volume $volume): void
    {
        $volume->setHostPath($this->source);
    }

    public function setType(HostPathVolumeType $type): self
    {
        $this->source->setType($type->value);

        return $this;
    }
}
