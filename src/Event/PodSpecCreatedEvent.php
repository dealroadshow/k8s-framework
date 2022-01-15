<?php

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\Pod\PodSpecInterface;

class PodSpecCreatedEvent
{
    public const NAME = 'dealroadshow_k8s.pod_spec.created';

    public function __construct(public readonly PodSpec $podSpec, public readonly PodSpecInterface $builder)
    {
    }
}
