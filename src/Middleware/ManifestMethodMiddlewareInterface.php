<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ManifestMethodMiddlewareInterface
{
    public function beforeMethodCall(ManifestInterface $manifest, string $methodName, array $params);
    public function priority(): int;
    public function supports(ManifestInterface $manifest, string $methodName, array $params): bool;
}
