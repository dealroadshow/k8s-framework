<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ManifestMethodPrefixMiddlewareInterface extends ManifestMethodMiddlewareInterface
{
    public function beforeMethodCall(ManifestInterface $proxy, string $methodName, array $params, mixed &$returnValue);
}
