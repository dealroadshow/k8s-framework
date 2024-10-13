<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration;

final readonly class EnvSourcesTrackingContext
{
    public function __construct(
        public string $dependentAppAlias,
        public string $dependencyAppAlias,
        private EnvSourcesRegistry $registry
    ) {
    }

    public function trackDependency(string $manifestClass): void
    {
        if ($this->dependentAppAlias === $this->dependencyAppAlias) {
            return;
        }

        $this->registry->trackDependency($this->dependentAppAlias, $this->dependencyAppAlias, $manifestClass);
    }
}
