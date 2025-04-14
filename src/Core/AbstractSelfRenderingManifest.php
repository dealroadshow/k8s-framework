<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\APIResourceInterface;

abstract class AbstractSelfRenderingManifest extends AbstractManifest implements SelfRenderingManifestInterface
{
    abstract public function data(): array|\JsonSerializable;
    abstract public static function apiVersion(): string;
    abstract public static function kind(): string;

    public function render(): ApiResourceInterface
    {
        $data = $this->data();
        if ($data instanceof \JsonSerializable) {
            $encoded = json_encode($data);
            if (false === $encoded) {
                throw new \RuntimeException(sprintf('Failed to encode data to JSON: %s. Data: "%s"', json_last_error_msg(), var_export($data, true)));
            }
            $data = json_decode($encoded, true);
        }

        return new GenericApiResource(static::apiVersion(), static::kind(), $this->data());
    }
}
