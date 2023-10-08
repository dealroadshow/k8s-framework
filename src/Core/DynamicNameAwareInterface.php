<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

interface DynamicNameAwareInterface
{
    public function name(): string;
}
