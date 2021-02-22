<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

abstract class AbstractManifestPrefixMiddleware implements ManifestMethodPrefixMiddlewareInterface
{
    public function beforeMethodCall(ManifestInterface $manifest, string $methodName, array $params, &$returnValue)
    {
    }

    public static function priority(): int
    {
        return 0;
    }
}