<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration;

use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;

final readonly class ExternalEnvSourcesTrackingContext
{
    public function __construct(
        private string $dependentAppAlias,
        private string $dependencyAppAlias,
        private ExternalEnvSourcesRegistry $registry
    ) {
    }

    public function trackDependency(string $manifestClass): void
    {
        $this->registry->trackDependency($this->dependentAppAlias, $this->dependencyAppAlias, $manifestClass);
    }

    public function throwOnInvalidMethodCall(string $methodFQN): void
    {
        throw new \BadMethodCallException(sprintf('Method "%s()" cannot be called after calling "%s::withExternalApp()": "%s()" does not depend on current app context, therefore such method call has no sense.', $methodFQN, EnvConfigurator::class, $methodFQN));
    }
}
