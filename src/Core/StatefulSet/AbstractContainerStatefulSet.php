<?php

namespace Dealroadshow\K8S\Framework\Core\StatefulSet;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;
use Dealroadshow\K8S\Framework\Core\Container\ContainerTrait;

class AbstractContainerStatefulSet extends AbstractStatefulSet implements ContainerInterface
{
    use ContainerTrait;

    public function containers(): iterable
    {
        yield $this;
    }
}
