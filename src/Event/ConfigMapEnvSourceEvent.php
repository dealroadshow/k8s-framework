<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class ConfigMapEnvSourceEvent implements StoppableEventInterface
{
    public const NAME = 'dealroadshow_k8s.env_source.config_map';

    private bool $propagationStopped = false;

    public function __construct(public readonly string $configMapClass, public readonly AppInterface $app)
    {
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }
}
