<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\PriorityClass;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface PriorityClassInterface extends ManifestInterface
{
    public function description(): string|null;
    public function globalDefault(): bool;
    public function preemptionPolicy(): PreemptionPolicy|null;
    public function value(): int;
}
