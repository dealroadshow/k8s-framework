<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class ManifestMiddlewareService
{
    /**
     * @param ManifestMethodPrefixMiddlewareInterface[] $prefixMiddlewares
     * @param ManifestMethodSuffixMiddlewareInterface[] $suffixMiddlewares
     */
    public function __construct(private iterable $prefixMiddlewares, private iterable $suffixMiddlewares)
    {
    }

    public function beforeMethodCall(ManifestInterface $proxy, string $methodName, array $params): mixed
    {
        foreach ($this->prefixMiddlewares as $middleware) {
            if ($middleware->supports($proxy, $methodName, $params)) {
                $returnValue = ManifestMethodPrefixMiddlewareInterface::NO_RETURN_VALUE;
                $middleware->beforeMethodCall($proxy, $methodName, $params, $returnValue);
                if (ManifestMethodMiddlewareInterface::NO_RETURN_VALUE !== $returnValue) {
                    return $returnValue;
                }
            }
        }

        return ManifestMethodPrefixMiddlewareInterface::NO_RETURN_VALUE;
    }

    public function afterMethodCall(ManifestInterface $proxy, string $methodName, array $params, mixed $returnedValue): mixed
    {
        foreach ($this->suffixMiddlewares as $middleware) {
            if ($middleware->supports($proxy, $methodName, $params)) {
                $returnValue = ManifestMethodPrefixMiddlewareInterface::NO_RETURN_VALUE;
                $middleware->afterMethodCall($proxy, $methodName, $params, $returnedValue, $returnValue);
                if (ManifestMethodMiddlewareInterface::NO_RETURN_VALUE !== $returnValue) {
                    return $returnValue;
                }
            }
        }

        return ManifestMethodPrefixMiddlewareInterface::NO_RETURN_VALUE;
    }
}
