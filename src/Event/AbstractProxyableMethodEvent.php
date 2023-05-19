<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\ProxyableInterface;

class AbstractProxyableMethodEvent implements ProxyableMethodEventInterface
{
    protected mixed $returnValue = null;
    protected bool $returnValueHasChanged = false;

    public function __construct(protected readonly ProxyableInterface $proxyable, protected readonly string $methodName, protected readonly array $methodParams)
    {
    }

    public function proxyable(): ProxyableInterface
    {
        return $this->proxyable;
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

    public function returnValueHasChanged(): bool
    {
        return $this->returnValueHasChanged;
    }

    public function setReturnValue(mixed $returnValue): void
    {
        $this->returnValue = $returnValue;
        $this->returnValueHasChanged = true;
    }
}
