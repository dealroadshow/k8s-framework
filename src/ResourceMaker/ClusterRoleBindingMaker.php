<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Rbac\ClusterRoleBinding;
use Dealroadshow\K8S\Data\RoleRef;
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
