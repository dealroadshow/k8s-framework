<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\APIResourceInterface;

interface SelfRenderingManifestInterface extends ManifestInterface
{
    public function render(): ApiResourceInterface;
}
