<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AbstractApp;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Config\ConfigAwareTrait;
use Dealroadshow\K8S\Framework\Util\Str;

abstract class AbstractManifest implements ManifestInterface
{
    use ConfigAwareTrait;

    protected AppInterface|AbstractApp $app;

    public function fileNameWithoutExtension(): string
    {
        return static::shortName().'.'.Str::asDNSSubdomain(static::kind());
    }

    public function metadata(MetadataConfigurator $meta): void
    {
    }

    public function setApp(AppInterface $app): void
    {
        $this->app = $app;
    }
}
