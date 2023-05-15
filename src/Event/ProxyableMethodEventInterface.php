<?php

namespace Dealroadshow\K8S\Framework\Event;
use Dealroadshow\K8S\Framework\Core\ProxyableInterface;

interface ProxyableMethodEventInterface
{
    public function proxyable(): ProxyableInterface;
    public function methodName(): string;
    public function methodParams(): array;
    public function getReturnValue(): mixed;
    public function setReturnValue(mixed $returnValue): void;
}
