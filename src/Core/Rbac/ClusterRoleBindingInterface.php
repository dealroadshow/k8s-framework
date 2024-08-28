<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding\SubjectsConfigurator;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding\RoleRefConfigurator;

interface ClusterRoleBindingInterface
{
    public function roleRef(RoleRefConfigurator $ref): void;
    public function subjects(SubjectsConfigurator $subjects): void;
}
