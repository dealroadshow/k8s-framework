<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\API\Secret;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Traits\StringifyTrait;

abstract class AbstractSecret extends AbstractManifest implements SecretInterface
{
    use StringifyTrait;

    public function data(StringMap $data): void
    {
    }

    public function stringData(StringMap $stringData): void
    {
    }

    public function keysPrefix(): string
    {
        return '';
    }

    public function type(): SecretType
    {
        return SecretType::Opaque;
    }

    public function configureSecret(Secret $secret): void
    {
    }

    final public static function kind(): string
    {
        return Secret::KIND;
    }
}
