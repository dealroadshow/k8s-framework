<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\StatefulSet;

final class PodManagementPolicy
{
    private const ORDERED_READY = 'OrderedReady';
    private const PARALLEL = 'Parallel';

    private function __construct(private string $policy)
    {
    }

    public static function orderedReady(): self
    {
        return new self(self::ORDERED_READY);
    }

    public static function parallel(): self
    {
        return new self(self::PARALLEL);
    }

    public function toString(): string
    {
        return $this->policy;
    }
}
