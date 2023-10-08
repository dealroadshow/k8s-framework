<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling;

final readonly class ScalingPolicy
{
    private const TYPE_PODS = 'Pods';
    private const TYPE_PERCENT = 'Percent';
    private const MIN_PERIOD_SECONDS = 0;
    private const MAX_PERIOD_SECONDS = 1800;

    public function __construct(public string $type, public int $amountOfChange, public int $periodSeconds)
    {
        if ($this->amountOfChange <= 0) {
            throw new \InvalidArgumentException('$amountOfChange must be greater than 0');
        }
        if ($this->periodSeconds <= self::MIN_PERIOD_SECONDS || $this->periodSeconds > self::MAX_PERIOD_SECONDS) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$periodSeconds must be greater than %d and less than or equal to %d',
                    self::MIN_PERIOD_SECONDS,
                    self::MAX_PERIOD_SECONDS
                )
            );
        }
    }

    public static function pods(int $amountOfChange, int $periodSeconds): self
    {
        return new self(self::TYPE_PODS, $amountOfChange, $periodSeconds);
    }

    public static function percents(int $amountOfChange, int $periodSeconds): self
    {
        return new self(self::TYPE_PERCENT, $amountOfChange, $periodSeconds);
    }
}
