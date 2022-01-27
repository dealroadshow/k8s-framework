<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\PriorityClass;

class PreemptionPolicy
{
    private const NEVER = 'Never';
    private const PREEMPT_LOWER_PRIORITY = 'PreemptLowerPriority';

    private function __construct(private string $value)
    {
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function never(): self
    {
        return new self(self::NEVER);
    }

    public static function preemptLowerPriority(): self
    {
        return new self(self::PREEMPT_LOWER_PRIORITY);
    }
}
