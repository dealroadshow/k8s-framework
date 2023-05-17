<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\Proximity\MethodsInterception\BodyInterceptorInterface;
use Dealroadshow\Proximity\MethodsInterception\ResultInterceptorInterface;
use Dealroadshow\Proximity\ProxyInterface;
use Dealroadshow\Proximity\ProxyOptions;

class ProxyFactory
{
    private array $bodyInterceptors;
    private array $resultInterceptors;

    /**
     * @param \Dealroadshow\Proximity\ProxyFactory $proxyFactory
     * @param BodyInterceptorInterface[] $bodyInterceptors
     * @param ResultInterceptorInterface[] $resultInterceptors
     */
    public function __construct(protected \Dealroadshow\Proximity\ProxyFactory $proxyFactory, iterable $bodyInterceptors, iterable $resultInterceptors)
    {
        $this->bodyInterceptors = $bodyInterceptors instanceof \Traversable ? iterator_to_array($bodyInterceptors) : $bodyInterceptors;
        $this->resultInterceptors = $resultInterceptors instanceof \Traversable ? iterator_to_array($resultInterceptors) : $resultInterceptors;
    }

    public function makeProxy(object $object): ProxyInterface
    {
        $options = new ProxyOptions(
            defaultBodyInterceptors: $this->bodyInterceptors,
            defaultResultInterceptors: $this->resultInterceptors
        );

        return $this->proxyFactory->proxy($object, $options);
    }
}
