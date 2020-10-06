<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

use Dealroadshow\K8S\Data\Collection\QuantityMap;
use Dealroadshow\K8S\Data\ResourceRequirements;
use Dealroadshow\K8S\ValueObject\Quantity;

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

    private function setCPU(CPU $cpu, QuantityMap $map): self
    {
        $quantity = Quantity::fromString($cpu->toString());
        $map->add(self::CPU, $quantity);

        return $this;
    }

    private function setMemory(string $key, Memory $memory, QuantityMap $map): self
    {
        $quantity = Quantity::fromString($memory->toString());
        $map->add(self::MEMORY, $quantity);

        return $this;
    }
}
