<?php

namespace Dealroadshow\K8S\Framework\Core\PriorityClass;

use Dealroadshow\K8S\API\Scheduling\PriorityClass;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractPriorityClass extends AbstractManifest implements PriorityClassInterface
{
    public static function kind(): string
    {
        return PriorityClass::KIND;
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
