<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Data\CrossVersionObjectReference;

final readonly class VersionedManifestReference
{
    public function __construct(public string $appAlias, public string $className, public string|null $apiVersion = null)
    {
    }
}
