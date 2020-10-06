<?php

namespace Dealroadshow\K8S\Framework\Core\Container\VolumeMount;

class MountPropagation
{
    private const NONE = 'None';
    private const HOST_TO_CONTAINER = 'HostToContainer';
    private const BIDIRECTIONAL = 'Bidirectional';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function none(): self
    {
        return new self(self::NONE);
    }

    public static function hostToContainer(): self
    {
        return new self(self::HOST_TO_CONTAINER);
    }

    public static function bidirectional(): self
    {
        return new self(self::BIDIRECTIONAL);
    }
}
