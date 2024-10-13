<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration\Localization;

use Dealroadshow\K8S\Framework\App\Integration\EnvSourcesRegistry;

abstract class AbstractLocalizationStrategy implements LocalizationStrategyInterface
{
    protected readonly EnvSourcesRegistry $envSourcesRegistry;

    public function setEnvSourcesRegistry(EnvSourcesRegistry $envSourcesRegistry): void
    {
        $this->envSourcesRegistry = $envSourcesRegistry;
    }
}
