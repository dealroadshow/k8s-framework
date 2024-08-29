<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

final readonly class VersionedManifestReference
{
    public function __construct(public string $appAlias, public string $className, public string|null $apiVersion = null)
    {
    }
}
