<?php

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\API\Secret;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractSecret extends AbstractManifest implements SecretInterface
{
    public function data(StringMap $data): void
    {
    }

    public function stringData(StringMap $stringData): void
    {
    }

    final public static function kind(): string
    {
        return Secret::KIND;
    }
}
