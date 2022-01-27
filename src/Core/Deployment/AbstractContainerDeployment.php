<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerTrait;

abstract class AbstractContainerDeployment extends AbstractDeployment implements ContainerInterface
{
    use ContainerTrait;

    public function containers(): iterable
    {
        yield $this;
    }
}
