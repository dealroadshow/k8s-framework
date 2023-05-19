<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ContainerMethodCalledEvent extends ContainerMethodEvent implements ProxyableMethodCalledEventInterface
{
    public const NAME = 'dealroadshow_k8s.container.method_called';

    public function __construct(ContainerInterface&ProxyInterface $proxyable, string $methodName, array $methodParams, private readonly mixed $returnedValue)
    {
        parent::__construct($proxyable, $methodName, $methodParams);
    }

    public function returnedValue(): mixed
    {
        return $this->returnedValue;
    }
}
