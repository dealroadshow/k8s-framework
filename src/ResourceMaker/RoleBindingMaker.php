<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Rbac\RoleBinding;
use Dealroadshow\K8S\Data\RoleRef;
use Dealroadshow\K8S\Framework\Core\Rbac\RoleBindingInterface;

class RoleBindingMaker extends AbstractRoleBindingMaker
{
    protected function roleBinding(RoleRef $ref): RoleBinding
    {
        return new RoleBinding($ref);
    }

    protected function supportsClass(): string
    {
        return RoleBindingInterface::class;
    }
}
