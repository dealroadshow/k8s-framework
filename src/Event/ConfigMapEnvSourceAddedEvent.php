<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;

readonly class ConfigMapEnvSourceAddedEvent
{
    public const NAME = 'dealroadshow_k8s.env_source.config_map.added';

    public function __construct(
        public string $configMapClass,
        public AppInterface $app,
        public EnvConfigurator $env
    ) {
    }
}
