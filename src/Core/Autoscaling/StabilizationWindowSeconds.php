<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling;

final readonly class StabilizationWindowSeconds
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 3600;

    private function __construct(public int $value)
    {
    }

    public static function fromInt(int $value): self
    {
        if ($value < self::MIN_VALUE || $value > self::MAX_VALUE) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$value must be greater that or equal to %d and less than or equal to %d',
                    self::MIN_VALUE,
                    self::MAX_VALUE
                )
            );
        }

        return new self($value);
    }
}
