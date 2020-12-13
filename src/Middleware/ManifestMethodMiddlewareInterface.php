<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ManifestMethodMiddlewareInterface
{
    const NO_RETURN_VALUE = 'MANIFEST_MIDDLEWARE_NO_RETURN_VALUE';

    public function beforeMethodCall(
        ManifestInterface $manifest,
        string $methodName,
        array $params,
        mixed &$returnValue
    );

    public function afterMethodCall(
        ManifestInterface $manifest,
        string $methodName,
        array $params,
        mixed $returnedValue,
        mixed &$returnValue
    );

    public function supports(ManifestInterface $manifest, string $methodName, array $params): bool;
    public static function priority(): int;
}
