<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ManifestMethodSuffixMiddlewareInterface extends ManifestMethodMiddlewareInterface
{
    public function afterMethodCall(ManifestInterface $proxy, ManifestInterface $manifest, string $methodName, array $params, mixed $returnedValue, mixed &$returnValue);
}
