<?php

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ConfigureMetaTrait;

abstract class AbstractSecret implements SecretInterface
{
    use ConfigureMetaTrait;

    public function data(StringMap $data): void
    {
    }

    public function stringData(StringMap $stringData): void
    {
    }
}
