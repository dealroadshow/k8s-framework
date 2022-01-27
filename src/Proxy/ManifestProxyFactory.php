<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Proxy;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Middleware\ManifestMethodMiddlewareInterface;
use Dealroadshow\K8S\Framework\Middleware\ManifestMethodPrefixMiddlewareInterface;
use Dealroadshow\K8S\Framework\Middleware\ManifestMiddlewareService;
use ProxyManager\Factory\AccessInterceptorScopeLocalizerFactory as ProxyFactory;

class ManifestProxyFactory
{
    public function __construct(private ManifestMiddlewareService $middlewareService)
    {
    }

    public function makeProxy(ManifestInterface $manifest): ManifestInterface
    {
        $factory = new ProxyFactory();

        $prefixClosure = function (
            ManifestInterface $proxy,
            ManifestInterface $proxyAgain,
            string $method,
            array $params,
            bool &$returnEarly
        ) {
            $result = $this->middlewareService->beforeMethodCall($proxy, $method, $params);
            if (ManifestMethodPrefixMiddlewareInterface::NO_RETURN_VALUE !== $result) {
                $returnEarly = true;
            }

            return $result;
        };

        $suffixClosure = function (
            ManifestInterface $proxy,
            ManifestInterface $proxyAgain,
            string $method,
            array $params,
            mixed $returnedValue,
            bool &$returnEarly
        ) {
            $result = $this->middlewareService->afterMethodCall($proxy, $method, $params, $returnedValue);
            if (ManifestMethodMiddlewareInterface::NO_RETURN_VALUE !== $result) {
                $returnEarly = true;
            }

            return $result;
        };

        $prefixClosures = [];
        $suffixClosures = [];
        $class = new \ReflectionClass($manifest);
        foreach ($class->getMethods() as $method) {
            if ($method->isFinal() || $method->isPrivate() || $method->isConstructor() || $method->isDestructor()) {
                continue;
            }
            $prefixClosures[$method->getName()] = $prefixClosure;
            $suffixClosures[$method->getName()] = $suffixClosure;
        }

        return $factory->createProxy($manifest, $prefixClosures, $suffixClosures);
    }
}
