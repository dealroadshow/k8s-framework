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

    public function beforeMethodCall(ManifestInterface $manifest, string $methodName, array $params)
    {
        foreach ($this->middlewares as $middleware) {
            if ($middleware->supports($manifest, $methodName, $params)) {
                $middleware->beforeMethodCall($manifest, $methodName, $params);
            }
        }
    }
}
