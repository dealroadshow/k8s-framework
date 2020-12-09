<?php

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Middleware\ManifestMiddlewareService;
use ProxyManager\Factory\AccessInterceptorValueHolderFactory as ProxyFactory;

class ManifestProxyFactory
{
    public function __construct(private ManifestMiddlewareService $middlewareService)
    {
    }

    public function makeProxy(ManifestInterface $manifest): ManifestInterface
    {
        $factory = new ProxyFactory();

        $closure = function(ManifestInterface $proxy, ManifestInterface $wrapped, string $method, array $params) {
            $this->middlewareService->beforeMethodCall($wrapped, $method, $params);
        };

        return $factory->createProxy($manifest, [$closure]);
    }
}
