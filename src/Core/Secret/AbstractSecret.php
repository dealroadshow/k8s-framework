<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Api\Core\V1\Secret;
use Dealroadshow\K8S\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractSecret extends AbstractManifest implements SecretInterface
{
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

    final public static function apiVersion(): string
    {
        return Secret::API_VERSION;
    }
}
