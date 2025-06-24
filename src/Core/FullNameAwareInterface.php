<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

interface FullNameAwareInterface
{
    public function fullName(): string;
}
