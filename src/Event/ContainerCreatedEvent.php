<?php

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Data\Container;
use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;

class ContainerCreatedEvent
{
    public const NAME = 'dealroadshow_k8s.container.created';

    public function __construct(public readonly Container $container, public readonly ContainerInterface $builder)
    {
    }
}
