<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Persistence;

use Dealroadshow\K8S\Data\ResourceRequirements;
use Dealroadshow\K8S\Data\VolumeResourceRequirements;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResource;
use Dealroadshow\K8S\Framework\Core\Container\Resources\Memory;

readonly class PvcResourcesConfigurator
{
    public function __construct(private VolumeResourceRequirements|ResourceRequirements $resources)
    {
    }

    public function requestStorage(Memory $memory): static
    {
        $this->resources->requests()->add(ContainerResource::STORAGE->value, $memory->toString());

        return $this;
    }

    public function limitStorage(Memory $memory): static
    {
        $this->resources->limits()->add(ContainerResource::STORAGE->value, $memory->toString());

        return $this;
    }
}
