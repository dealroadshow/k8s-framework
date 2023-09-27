<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Persistence;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResource;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesInterface;
use Dealroadshow\K8S\Framework\Core\Container\Resources\CPU;
use Dealroadshow\K8S\Framework\Core\Container\Resources\Memory;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesConfigurator;

class PvcResourcesConfigurator extends ResourcesConfigurator implements ContainerResourcesInterface
{
    public function requestCPU(CPU $cpu): static
    {
        throw $this->createException(__METHOD__);
    }

    public function requestMemory(Memory $memory): static
    {
        throw $this->createException(__METHOD__);
    }

    public function limitCPU(CPU $cpu): static
    {
        throw $this->createException(__METHOD__);
    }

    public function limitMemory(Memory $memory): static
    {
        throw $this->createException(__METHOD__);
    }

    public function requestStorage(Memory $memory): static
    {
        return $this->setMemory(ContainerResource::STORAGE, $memory, $this->resources->requests());
    }

    public function limitStorage(Memory $memory): static
    {
        return $this->setMemory(ContainerResource::STORAGE, $memory, $this->resources->limits());
    }

    private function createException(string $methodName): \BadMethodCallException
    {
        return new \BadMethodCallException(
            sprintf(
                'Method "%s()" is not supported in %s',
                $methodName,
                __CLASS__
            )
        );
    }
}
