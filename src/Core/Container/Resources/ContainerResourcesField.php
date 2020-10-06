<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

use Dealroadshow\K8S\Data\ResourceFieldSelector;
use Dealroadshow\K8S\ValueObject\Quantity;

class ContainerResourcesField
{
    private const LIMITS_CPU = 'limits.cpu';
    private const LIMITS_MEMORY = 'limits.memory';
    private const LIMITS_EPHEMERAL_STORAGE = 'limits.ephemeral-storage';
    private const REQUESTS_CPU = 'requests.cpu';
    private const REQUESTS_MEMORY = 'requests.memory';
    private const REQUESTS_EPHEMERAL_STORAGE = 'requests.ephemeral-storage';

    private ResourceFieldSelector $selector;

    private function __construct(string $resourceName)
    {
        $this->selector = new ResourceFieldSelector($resourceName);
    }

    public function selector(): ResourceFieldSelector
    {
        return $this->selector;
    }

    public function setContainerName(?string $containerName): self
    {
        $this->selector->setContainerName($containerName);

        return $this;
    }

    public function setDivisor(string $divisor): self
    {
        $this->selector->setDivisor(Quantity::fromString($divisor));

        return $this;
    }

    public static function cpuLimits(): self
    {
        return new self(self::LIMITS_CPU);
    }

    public static function cpuRequests(): self
    {
        return new self(self::REQUESTS_CPU);
    }

    public static function memoryLimits(): self
    {
        return new self(self::LIMITS_MEMORY);
    }

    public static function memoryRequests(): self
    {
        return new self(self::REQUESTS_MEMORY);
    }

    public static function storageLimits(): self
    {
        return new self(self::LIMITS_EPHEMERAL_STORAGE);
    }

    public static function storageRequests(): self
    {
        return new self(self::REQUESTS_EPHEMERAL_STORAGE);
    }
}