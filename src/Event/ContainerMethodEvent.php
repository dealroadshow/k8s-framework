<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ContainerMethodEvent extends AbstractProxyableMethodEvent
{
    public const NAME = 'dealroadshow_k8s.container.before_method';

    public function __construct(ContainerInterface&ProxyInterface $proxyable, string $methodName, array $methodParams)
    {
        parent::__construct($proxyable, $methodName, $methodParams);
    }

    public function container(): ContainerInterface&ProxyInterface
    {
        return $this->proxyable;
    }
}
