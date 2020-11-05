<?php

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AppAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface SecretInterface extends ManifestInterface, AppAwareInterface
{
    public function data(StringMap $data): void;
    public function stringData(StringMap $stringData): void;
}
