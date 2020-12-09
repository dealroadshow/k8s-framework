<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class ManifestMiddlewareService
{
    /**
     * @param ManifestMethodMiddlewareInterface[] $middlewares
     */
    public function __construct(private iterable $middlewares)
    {
    }

    public function beforeMethodCall(ManifestInterface $manifest, string $methodName, array $params): mixed
    {
        foreach ($this->middlewares as $middleware) {
            if ($middleware->supports($manifest, $methodName, $params)) {
                $returnValue = ManifestMethodMiddlewareInterface::NO_RETURN_VALUE;
                $middleware->beforeMethodCall($manifest, $methodName, $params, $returnValue);
                if (ManifestMethodMiddlewareInterface::NO_RETURN_VALUE !== $returnValue) {
                    return $returnValue;
                }
            }
        }

        return ManifestMethodMiddlewareInterface::NO_RETURN_VALUE;
    }
}
