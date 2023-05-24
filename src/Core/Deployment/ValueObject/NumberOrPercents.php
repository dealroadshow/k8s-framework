<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Deployment\ValueObject;

final readonly class NumberOrPercents
{
    private function __construct(public int|string $value)
    {
    }

    public static function number(int $number): self
    {
        return new self($number);
    }

    public static function percents(int $percents): self
    {
        return new self($percents .'%');
    }
}
