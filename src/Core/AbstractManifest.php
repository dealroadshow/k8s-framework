<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;

abstract class AbstractManifest implements ManifestInterface
{
    protected AppInterface $app;
    protected array $config = [];

    public function metadata(MetadataConfigurator $meta): void
    {
    }

    public function setApp(AppInterface $app): void
    {
        $this->app = $app;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
