<?php

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Middleware\ManifestMethodMiddlewareInterface;
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

        $closure = function(
            ManifestInterface $proxy,
            ManifestInterface $wrapped,
            string $method,
            array $params,
            bool &$returnEarly
        ) {
            $result = $this->middlewareService->beforeMethodCall($wrapped, $method, $params);
            if (ManifestMethodMiddlewareInterface::NO_RETURN_VALUE !== $result) {
                $returnEarly = true;
            }

            return $result;
        };

        $closures = [];
        $class = new \ReflectionClass($manifest);
        foreach ($class->getMethods() as $method) {
            if ($method->isFinal() || $method->isPrivate() || $method->isConstructor() || $method->isDestructor()) {
                continue;
            }
            $closures[$method->getName()] = $closure;
        }

        return $factory->createProxy($manifest, $closures);
    }
}
