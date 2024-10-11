<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration\Localization;

/**
 * This class uses a strategy ( @see \Dealroadshow\K8S\Framework\App\Integration\Localization\LocalizationStrategyInterface )
 * to "localize" external configuration dependencies, such as ConfigMaps and Secrets,
 * that some K8S app depends on from other apps. Please see docs for @see \Dealroadshow\K8S\Framework\App\Integration\Localization\LocalizationStrategyInterface
 * in order to get more information about "localization".
 */
class ExternalConfigurationLocalizer
{
    public function __construct(private LocalizationStrategyInterface $strategy)
    {
    }

    public function localizeDependencies(string $dependentAppAlias, array $dependencies): void
    {
        $this->strategy->localize($dependentAppAlias, $dependencies);
    }
}
