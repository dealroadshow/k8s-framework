<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Runtime;

final readonly class DelegatingRuntimeStatusResolver implements ManifestRuntimeStatusResolverInterface
{
    /**
     * @param ManifestStatusResolverStrategyInterface[] $strategies
     */
    public function __construct(private iterable $strategies)
    {
    }

    public function isClassEnabled(\ReflectionClass $class): bool
    {
        foreach ($this->strategies as $strategy) {
            if (!$strategy->isClassEnabled($class)) {
                return false;
            }
        }

        return true;
    }
}
