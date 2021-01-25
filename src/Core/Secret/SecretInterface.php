<?php

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface SecretInterface extends ManifestInterface
{
    public function data(StringMap $data): void;
    public function stringData(StringMap $stringData): void;
    public function keysPrefix(): string;
}
