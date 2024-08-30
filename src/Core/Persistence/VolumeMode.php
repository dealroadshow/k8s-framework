<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Persistence;

final readonly class VolumeMode
{
    private const FILESYSTEM = 'Filesystem';
    private const BLOCK = 'Block';

    private function __construct(private string $mode)
    {
    }

    public function toString(): string
    {
        return $this->mode;
    }

    public static function filesystem(): self
    {
        return new self(self::FILESYSTEM);
    }

    public static function block(): self
    {
        return new self(self::BLOCK);
    }
}
