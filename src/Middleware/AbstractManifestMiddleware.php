<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

abstract class AbstractManifestMiddleware implements ManifestMethodMiddlewareInterface
{
    public function beforeMethodCall(ManifestInterface $manifest, string $methodName, array $params, &$returnValue)
    {
    }

    public function afterMethodCall(ManifestInterface $manifest, string $methodName, array $params, mixed $returnedValue, mixed &$returnValue)
    {
    }

    public static function priority(): int
    {
        return 0;
    }
}