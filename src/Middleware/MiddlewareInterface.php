<?php

namespace Dealroadshow\K8S\Framework\Middleware;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface MiddlewareInterface
{
    public function before(ManifestInterface $manifest): void;
    public function after(ManifestInterface $manifest, APIResourceInterface $resource): void;
}
