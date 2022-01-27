<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\CronJob;

class ConcurrencyPolicy
{
    private const ALLOW = 'Allow';
    private const FORBID = 'Forbid';
    private const REPLACE = 'Replace';

    private function __construct(private string $value)
    {
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function allow(): static
    {
        return new static(self::ALLOW);
    }

    public static function forbid(): static
    {
        return new static(self::FORBID);
    }

    public static function replace(): static
    {
        return new static(self::REPLACE);
    }
}
