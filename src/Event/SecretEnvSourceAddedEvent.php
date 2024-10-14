<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\Env\EnvConfigurator;

readonly class SecretEnvSourceAddedEvent
{
    public const NAME = 'dealroadshow_k8s.env_source.secret.added';

    public function __construct(
        public string $secretClass,
        public AppInterface $app,
        public EnvConfigurator $env
    ) {
    }
}
