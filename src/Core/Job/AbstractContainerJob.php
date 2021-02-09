<?php

namespace Dealroadshow\K8S\Framework\Core\Job;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerTrait;

abstract class AbstractContainerJob extends AbstractJob implements ContainerInterface
{
    use ContainerTrait;

    public function containers(): iterable
    {
        yield $this;
    }
}
