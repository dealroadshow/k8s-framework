<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\PriorityClass;

use Dealroadshow\K8S\Api\Scheduling\V1\PriorityClass;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractPriorityClass extends AbstractManifest implements PriorityClassInterface
{
    final public static function kind(): string
    {
        return PriorityClass::KIND;
    }

    public static function apiVersion(): string
    {
        return PriorityClass::API_VERSION;
    }

    public function description(): string|null
    {
        return null;
    }

    public function globalDefault(): bool
    {
        return false;
    }

    public function preemptionPolicy(): PreemptionPolicy|null
    {
        return null;
    }
}
