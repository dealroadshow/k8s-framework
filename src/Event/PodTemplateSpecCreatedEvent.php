<?php

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Data\PodTemplateSpec;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;

class PodTemplateSpecCreatedEvent
{
    public const NAME = 'dealroadshow_k8s.pod_template_spec.created';

    public function __construct(public readonly PodTemplateSpec $templateSpec, public readonly PodTemplateSpecInterface $builder)
    {
    }
}
