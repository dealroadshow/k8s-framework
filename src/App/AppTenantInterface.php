<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App;

interface AppTenantInterface
{
    public function name(): string;

    public function appAlias(): string;
}
