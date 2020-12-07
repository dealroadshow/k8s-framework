<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder;

use Dealroadshow\K8S\Data\EmptyDirVolumeSource;
use Dealroadshow\K8S\Data\Volume;
use Dealroadshow\K8S\Framework\Core\Container\Resources\Memory;

class EmptyDirVolumeBuilder extends AbstractVolumeBuilder
{
    private const MEDIUM_MEMORY = 'Memory';

    private EmptyDirVolumeSource $source;

    public function __construct()
    {
        $this->source = new EmptyDirVolumeSource();
    }

    public function init(Volume $volume): void
    {
        $this->source = $volume->emptyDir();
    }

    public function useRAM(): self
    {
        $this->source->setMedium(self::MEDIUM_MEMORY);

        return $this;
    }

    public function setSizeLimit(Memory $memory): self
    {
        $this->source->setSizeLimit($memory->toString());

        return $this;
    }
}
