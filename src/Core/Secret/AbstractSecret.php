<?php

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ConfigureMetaTrait;
use Dealroadshow\K8S\Framework\Core\ConfigureTagsTrait;

abstract class AbstractSecret implements SecretInterface
{
    use ConfigureMetaTrait;
    use ConfigureTagsTrait;

    public function data(StringMap $data): void
    {
    }

    public function stringData(StringMap $stringData): void
    {
    }
}
