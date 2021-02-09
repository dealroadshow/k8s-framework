<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Data\Collection\VolumeList;
use Dealroadshow\K8S\Data\Container;
use Dealroadshow\K8S\Framework\App\AppInterface;

interface ContainerMakerInterface
{
    public function make(ContainerInterface $manifest, VolumeList $volumes, AppInterface $app): Container;
}
