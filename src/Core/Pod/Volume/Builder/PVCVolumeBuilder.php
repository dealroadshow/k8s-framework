<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder;

use Dealroadshow\K8S\Data\PersistentVolumeClaimVolumeSource;
use Dealroadshow\K8S\Data\Volume;

class PVCVolumeBuilder extends AbstractVolumeBuilder
{
    private PersistentVolumeClaimVolumeSource $source;

    public function __construct(private string $pvcName)
    {
    }

    public function init(Volume $volume): void
    {
        $this->source = new PersistentVolumeClaimVolumeSource($this->pvcName);
        $volume->setPersistentVolumeClaim($this->source);
    }

    public function setReadOnly(): void
    {
        $this->source->setReadOnly(true);
    }
}
