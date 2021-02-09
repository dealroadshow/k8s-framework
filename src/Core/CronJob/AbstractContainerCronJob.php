<?php

namespace Dealroadshow\K8S\Framework\Core\CronJob;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerTrait;

abstract class AbstractContainerCronJob extends AbstractCronJob implements ContainerInterface
{
    use ContainerTrait;

    public function containers(): iterable
    {
        yield $this;
    }
}
