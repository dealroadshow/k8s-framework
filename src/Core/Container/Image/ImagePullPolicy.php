<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Image;

class ImagePullPolicy
{
    private const ALWAYS         = 'Always';
    private const NEVER          = 'Never';
    private const IF_NOT_PRESENT = 'IfNotPresent';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function always(): self
    {
        return new self(self::ALWAYS);
    }

    public static function never(): self
    {
        return new self(self::NEVER);
    }

    public static function ifNotPresent(): self
    {
        return new self(self::IF_NOT_PRESENT);
    }
}
