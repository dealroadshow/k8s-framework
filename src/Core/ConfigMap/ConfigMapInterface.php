<?php

namespace Dealroadshow\K8S\Framework\Core\ConfigMap;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ConfigMapInterface extends ManifestInterface
{
    public function data(StringMap $data): void;
    public function binaryData(StringMap $binaryData): void;
    public function keysPrefix(): string;
}
