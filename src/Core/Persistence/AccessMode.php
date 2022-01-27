<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Persistence;

final class AccessMode
{
    private const READ_WRITE_ONCE = 'ReadWriteOnce';
    private const READ_ONLY_MANY = 'ReadOnlyMany';
    private const READ_WRITE_MANY = 'ReadWriteMany';

    private function __construct(private string $mode)
    {
    }

    public function toString(): string
    {
        return $this->mode;
    }

    public static function readWriteOnce(): self
    {
        return new self(self::READ_WRITE_ONCE);
    }

    public static function readOnlyMany(): self
    {
        return new self(self::READ_ONLY_MANY);
    }

    public static function readWriteMany(): self
    {
        return new self(self::READ_WRITE_MANY);
    }
}
