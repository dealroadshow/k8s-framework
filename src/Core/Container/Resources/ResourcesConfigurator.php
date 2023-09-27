<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

use Dealroadshow\K8S\Data\Collection\StringOrFloatMap;
use Dealroadshow\K8S\Data\ResourceRequirements;

class ResourcesConfigurator implements ContainerResourcesInterface
{
    public function __construct(protected ResourceRequirements $resources)
    {
    }

    public function requestCPU(CPU $cpu): static
    {
        return $this->setCPU($cpu, $this->resources->requests());
    }

    public function requestMemory(Memory $memory): static
    {
        return $this->setMemory(ContainerResource::MEMORY, $memory, $this->resources->requests());
    }

    public function requestStorage(Memory $memory): static
    {
        return $this->setMemory(ContainerResource::EPHEMERAL_STORAGE, $memory, $this->resources->requests());
    }

    public function limitCPU(CPU $cpu): static
    {
        return $this->setCPU($cpu, $this->resources->limits());
    }

    public function limitMemory(Memory $memory): static
    {
        return $this->setMemory(ContainerResource::MEMORY, $memory, $this->resources->limits());
    }

    public function limitStorage(Memory $memory): static
    {
        return $this->setMemory(ContainerResource::EPHEMERAL_STORAGE, $memory, $this->resources->limits());
    }

    private function setCPU(CPU $cpu, StringOrFloatMap $map): static
    {
        $map->add(ContainerResource::CPU->value, $cpu->toString());

        return $this;
    }

    protected function setMemory(ContainerResource $resource, Memory $memory, StringOrFloatMap $map): static
    {
        $map->add($resource->value, $memory->toString());

        return $this;
    }
}
