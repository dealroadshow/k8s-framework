<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

readonly class EnvConfiguratorWithExternalAppEvent
{
    public const NAME = 'dealroadshow_k8s.env_configurator.with_external_app';

    public function __construct(public string $dependentAppAlias, public string $dependencyAppAlias)
    {
    }
}
