<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\Proximity\MethodsInterception\BodyInterceptorInterface;
use Dealroadshow\Proximity\MethodsInterception\ResultInterceptorInterface;
use Dealroadshow\Proximity\ProxyFactory;
use Dealroadshow\Proximity\ProxyInterface;
use Dealroadshow\Proximity\ProxyOptions;

class ManifestProxyFactory
{
    private array $bodyInterceptors;
    private array $resultInterceptors;

    /**
     * @param ProxyFactory $proxyFactory
     * @param BodyInterceptorInterface[] $bodyInterceptors
     * @param ResultInterceptorInterface[] $resultInterceptors
     */
    public function __construct(private ProxyFactory $proxyFactory, iterable $bodyInterceptors, iterable $resultInterceptors)
    {
        $this->bodyInterceptors = $bodyInterceptors instanceof \Traversable ? iterator_to_array($bodyInterceptors) : $bodyInterceptors;
        $this->resultInterceptors = $resultInterceptors instanceof \Traversable ? iterator_to_array($resultInterceptors) : $resultInterceptors;
    }

    public function makeProxy(ManifestInterface $manifest): ManifestInterface&ProxyInterface
    {
        $options = new ProxyOptions(
            defaultBodyInterceptors: $this->bodyInterceptors,
            defaultResultInterceptors: $this->resultInterceptors
        );

        return $this->proxyFactory->proxy($manifest, $options);
    }
}
