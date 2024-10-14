<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App;

interface TenantAwareAppInterface
{
    public function tenant(): AppTenantInterface;

    public function tenantName(): string;
}
