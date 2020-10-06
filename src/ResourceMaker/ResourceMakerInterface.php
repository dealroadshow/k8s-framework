<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ResourceMakerInterface
{
    public function make(ManifestInterface $manifest, AppInterface $app): APIResourceInterface;
    public function supports(ManifestInterface $manifest, AppInterface $app): bool;
}
