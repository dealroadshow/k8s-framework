<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\ProxyableInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ContainerMethodEvent implements ProxyableMethodEventInterface
{
    public const NAME = 'dealroadshow_k8s.container.before_method';

    private mixed $returnValue = null;

    public function __construct(private readonly ContainerInterface&ProxyInterface $container, private readonly string $methodName, private readonly array $methodParams)
    {
    }

    public function proxyable(): ProxyableInterface
    {
        return $this->container;
    }

    public function container(): ContainerInterface&ProxyInterface
    {
        return $this->container;
    }

    public function methodName(): string
    {
        return $this->methodName;
    }

    public function methodParams(): array
    {
        return $this->methodParams;
    }

    public function getReturnValue(): mixed
    {
        return $this->returnValue;
    }

    public function setReturnValue(mixed $returnValue): void
    {
        $this->returnValue = $returnValue;
    }
}
