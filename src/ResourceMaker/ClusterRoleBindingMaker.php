<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Rbac\V1\ClusterRoleBinding;
use Dealroadshow\K8S\Api\Rbac\V1\RoleRef;
use Dealroadshow\K8S\Framework\Core\Rbac\ClusterRoleBindingInterface;

class ClusterRoleBindingMaker extends AbstractRoleBindingMaker
{
    protected function roleBinding(RoleRef $ref): ClusterRoleBinding
    {
        return new ClusterRoleBinding($ref);
    }

    protected function supportsClass(): string
    {
        return ClusterRoleBindingInterface::class;
    }
}
