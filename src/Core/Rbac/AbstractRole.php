<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\API\Rbac\Role;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractRole extends AbstractManifest implements RoleInterface
{
    public function configureRole(Role $role): void
    {
    }

    public static function apiVersion(): string
    {
        return Role::API_VERSION;
    }

    public static function kind(): string
    {
        return Role::KIND;
    }
}
