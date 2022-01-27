<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Data\Container;
use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;

class ContainerGeneratedEvent
{
    public const NAME = 'dealroadshow_k8s.container.generated';

    public function __construct(public readonly Container $container, public readonly ContainerInterface $builder)
    {
    }
}
