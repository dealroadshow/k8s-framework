<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

class ContainerResourcesCallback
{
    private CPU|null $cpuRequests = null;
    private CPU|null $cpuLimits = null;
    private Memory|null $memoryRequests = null;
    private Memory|null $memoryLimits = null;
    private Memory|null $storageRequests = null;
    private Memory|null $storageLimits = null;

    private function __construct()
    {
    }

    public function apply(ResourcesConfigurator $resources): void
    {
        if ($this->cpuRequests) {
            $resources->requestCPU($this->cpuRequests);
        }
        if ($this->cpuLimits) {
            $resources->limitCPU($this->cpuLimits);
        }
        if ($this->memoryRequests) {
            $resources->requestMemory($this->memoryRequests);
        }
        if ($this->memoryLimits) {
            $resources->limitMemory($this->memoryLimits);
        }
        if ($this->storageRequests) {
            $resources->requestStorage($this->storageRequests);
        }
        if ($this->storageLimits) {
            $resources->limitStorage($this->storageLimits);
        }
    }

    public function requestCpu(CPU $cpu): static
    {
        $this->cpuRequests = $cpu;

        return $this;
    }

    public function limitCPU(CPU $cpu): static
    {
        $this->cpuLimits = $cpu;

        return $this;
    }

    public function requestMemory(Memory $memory): static
    {
        $this->memoryRequests = $memory;

        return $this;
    }

    public function limitMemory(Memory $memory): static
    {
        $this->memoryLimits = $memory;

        return $this;
    }

    public function requestStorage(Memory $memory): static
    {
        $this->storageRequests = $memory;

        return $this;
    }

    public function limitStorage(Memory $memory): static
    {
        $this->storageLimits = $memory;

        return $this;
    }

    public static function define(): static
    {
        return new static();
    }
}
