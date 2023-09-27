<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling\Metric;

final readonly class TypedMetricTarget
{
    private function __construct(public TargetType $type, public string|float|int $value)
    {
    }

    public static function utilization(int $averageUtilization): self
    {
        return new self(TargetType::Utilization, $averageUtilization);
    }

    public static function value(float|string $value): self
    {
        return new self(TargetType::Value, $value);
    }

    public static function averageValue(float|string $value): self
    {
        return new self(TargetType::AverageValue, $value);
    }
}
