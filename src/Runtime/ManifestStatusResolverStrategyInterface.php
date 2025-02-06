<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Runtime;

interface ManifestStatusResolverStrategyInterface
{
    public function isClassEnabled(\ReflectionClass $class): bool;
}
