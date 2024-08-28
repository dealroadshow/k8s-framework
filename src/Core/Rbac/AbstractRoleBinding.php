<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\API\Rbac\RoleBinding;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractRoleBinding extends AbstractManifest implements RoleBindingInterface
{
    public static function apiVersion(): string
    {
        return RoleBinding::API_VERSION;
    }

    public static function kind(): string
    {
        return RoleBinding::KIND;
    }
}
