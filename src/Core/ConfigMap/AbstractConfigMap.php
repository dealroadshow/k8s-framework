<?php

namespace Dealroadshow\K8S\Framework\Core\ConfigMap;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ConfigureMetaTrait;

abstract class AbstractConfigMap implements ConfigMapInterface
{
    use ConfigureMetaTrait;

    public function data(StringMap $data): void
    {
    }

    public function binaryData(StringMap $binaryData): void
    {
    }
}
