<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Api\Core\V1\Container;
use Dealroadshow\K8S\Api\Core\V1\VolumeList;
use Dealroadshow\K8S\Framework\App\AppInterface;

interface ContainerMakerInterface
{
    public function make(ContainerInterface $builder, VolumeList $volumes, AppInterface $app): Container;
}
