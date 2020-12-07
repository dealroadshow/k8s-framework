<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

use Dealroadshow\K8S\Data\Collection\StringOrFloatMap;
use Dealroadshow\K8S\Data\ResourceRequirements;

class ResourcesConfigurator
{
    private const CPU = 'cpu';
    private const MEMORY = 'memory';
    private const EPHEMERAL_STORAGE = 'ephemeral-storage';

    private ResourceRequirements $resources;

    public function __construct(ResourceRequirements $resources)
    {
        $this->resources = $resources;
    }

    public function requestCPU(CPU $cpu): self
    {
        return $this->setCPU($cpu, $this->resources->requests());
    }

    public function requestMemory(Memory $memory): self
    {
        return $this->setMemory(self::MEMORY, $memory, $this->resources->requests());
    }

    public function requestStorage(Memory $memory): self
    {
        return $this->setMemory(self::EPHEMERAL_STORAGE, $memory, $this->resources->requests());
    }

    public function limitCPU(CPU $cpu): self
    {
        return $this->setCPU($cpu, $this->resources->limits());
    }

    public function limitMemory(Memory $memory): self
    {
        return $this->setMemory(self::MEMORY, $memory, $this->resources->limits());
    }

    public function limitStorage(Memory $memory): self
    {
        return $this->setMemory(self::EPHEMERAL_STORAGE, $memory, $this->resources->limits());
    }

    private function setCPU(CPU $cpu, StringOrFloatMap $map): self
    {
        $map->add(self::CPU, $cpu->toString());

        return $this;
    }

    private function setMemory(string $key, Memory $memory, StringOrFloatMap $map): self
    {
        $map->add($key, $memory->toString());

        return $this;
    }
}
