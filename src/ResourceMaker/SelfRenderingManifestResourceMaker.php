<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\SelfRenderingManifestInterface;

class SelfRenderingManifestResourceMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return SelfRenderingManifestInterface::class;
    }

    protected function makeResource(ManifestInterface|SelfRenderingManifestInterface $manifest, AppInterface $app): APIResourceInterface
    {
        return $manifest->render();
    }
}
