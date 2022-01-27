<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

abstract class AbstractManifestSuffixMiddleware implements ManifestMethodSuffixMiddlewareInterface
{
    public function afterMethodCall(ManifestInterface $manifest, string $methodName, array $params, mixed $returnedValue, mixed &$returnValue): void
    {
    }

    public static function priority(): int
    {
        return 0;
    }
}
