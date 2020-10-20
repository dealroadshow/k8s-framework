<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\Framework\Core\Container\Image\Image;

interface ContainerImageMiddlewareInterface
{
    public function apply(Image $image): void;
    public function priority(): int;
}
