<?php

namespace Dealroadshow\K8S\Framework\Core\ConfigMap;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ConfigureMetaTrait;
use Dealroadshow\K8S\Framework\Core\ConfigureTagsTrait;

abstract class AbstractConfigMap implements ConfigMapInterface
{
    use ConfigureMetaTrait;
    use ConfigureTagsTrait;

    public function data(StringMap $data): void
    {
    }

    public function binaryData(StringMap $binaryData): void
    {
    }
}
