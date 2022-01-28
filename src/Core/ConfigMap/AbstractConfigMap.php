<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\ConfigMap;

use Dealroadshow\K8S\API\ConfigMap;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Traits\StringifyTrait;

abstract class AbstractConfigMap extends AbstractManifest implements ConfigMapInterface
{
    use StringifyTrait;

    public function data(StringMap $data): void
    {
    }

    public function binaryData(StringMap $binaryData): void
    {
    }

    public function keysPrefix(): string
    {
        return '';
    }

    public function configureConfigMap(ConfigMap $configMap): void
    {
    }

    final public static function kind(): string
    {
        return ConfigMap::KIND;
    }
}
