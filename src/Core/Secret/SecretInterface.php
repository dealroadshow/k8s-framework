<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Api\Core\V1\Secret;
use Dealroadshow\K8S\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface SecretInterface extends ManifestInterface
{
    public function data(StringMap $data): void;
    public function stringData(StringMap $stringData): void;
    public function keysPrefix(): string;
    public function type(): SecretType;
    public function configureSecret(Secret $secret): void;
}
