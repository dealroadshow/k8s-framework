<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder;

use Dealroadshow\K8S\Api\Core\V1\DownwardAPIVolumeFile;
use Dealroadshow\K8S\Api\Core\V1\DownwardAPIVolumeSource;
use Dealroadshow\K8S\Api\Core\V1\Volume;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesField;
use Dealroadshow\K8S\Framework\Core\Pod\PodField;

class DownwardAPIVolumeBuilder extends AbstractVolumeBuilder
{
    private DownwardAPIVolumeSource $source;

    public function init(Volume $volume): void
    {
        $this->source = $volume->downwardAPI();
    }

    public function setDefaultMode(int $mode): self
    {
        $this->source->setDefaultMode($mode);

        return $this;
    }

    public function exposePodInfo(string $filePath, PodField $podField, int $mode = null): self
    {
        $file = new DownwardAPIVolumeFile($filePath);
        $file->setFieldRef($podField->selector());
        if (null !== $mode) {
            $file->setMode($mode);
        }

        $this->source->items()->add($file);

        return $this;
    }

    public function exposeContainerResources(string $filePath, ContainerResourcesField $resourcesField, int $mode = null): self
    {
        $file = new DownwardAPIVolumeFile($filePath);
        $file->setResourceFieldRef($resourcesField->selector());
        if (null !== $mode) {
            $file->setMode($mode);
        }

        $this->source->items()->add($file);

        return $this;
    }
}
