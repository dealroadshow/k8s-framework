<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

interface ContainerResourcesInterface
{
    public function requestCPU(CPU $cpu): static;
    public function requestMemory(Memory $memory): static;
    public function requestStorage(Memory $memory): static;
    public function limitCPU(CPU $cpu): static;
    public function limitMemory(Memory $memory): static;
    public function limitStorage(Memory $memory): static;
}
