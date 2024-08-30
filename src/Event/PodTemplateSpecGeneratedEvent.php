<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Core\V1\PodTemplateSpec;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;

class PodTemplateSpecGeneratedEvent
{
    public const NAME = 'dealroadshow_k8s.pod_template_spec.generated';

    public function __construct(public readonly PodTemplateSpec $templateSpec, public readonly PodTemplateSpecInterface $builder)
    {
    }
}
