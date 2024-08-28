<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\API\Rbac\ClusterRoleBinding;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractClusterRoleBinding extends AbstractManifest implements ClusterRoleBindingInterface
{
    public static function apiVersion(): string
    {
        return ClusterRoleBinding::API_VERSION;
    }

    public static function kind(): string
    {
        return ClusterRoleBinding::KIND;
    }
}
