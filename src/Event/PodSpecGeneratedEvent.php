<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Core\V1\PodSpec;
use Dealroadshow\K8S\Framework\Core\Pod\PodSpecInterface;

class PodSpecGeneratedEvent
{
    public const NAME = 'dealroadshow_k8s.pod_spec.generated';

    public function __construct(public readonly PodSpec $podSpec, public readonly PodSpecInterface $builder)
    {
    }
}
