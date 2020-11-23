<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Config\ConfigAwareTrait;

abstract class AbstractManifest implements ManifestInterface
{
    use ConfigAwareTrait;

    protected AppInterface $app;

    public function metadata(MetadataConfigurator $meta): void
    {
    }

    public function setApp(AppInterface $app): void
    {
        $this->app = $app;
    }
}
