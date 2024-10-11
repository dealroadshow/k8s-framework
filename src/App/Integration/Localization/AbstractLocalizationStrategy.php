<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration\Localization;

use Dealroadshow\K8S\Framework\App\Integration\ExternalEnvSourcesRegistry;

abstract class AbstractLocalizationStrategy implements LocalizationStrategyInterface
{
    protected readonly ExternalEnvSourcesRegistry $envSourcesRegistry;

    public function setEnvSourcesRegistry(ExternalEnvSourcesRegistry $envSourcesRegistry): void
    {
        $this->envSourcesRegistry = $envSourcesRegistry;
    }
}
