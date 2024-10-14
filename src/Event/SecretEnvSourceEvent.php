<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class SecretEnvSourceEvent implements StoppableEventInterface
{
    public const NAME = 'dealroadshow_k8s.env_source.secret';

    private bool $propagationStopped = false;

    public function __construct(public readonly string $secretClass, public readonly AppInterface $app)
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
