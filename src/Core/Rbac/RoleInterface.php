<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\API\Rbac\Role;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\PolicyRulesConfigurator;

interface RoleInterface extends ManifestInterface
{
    public function rules(PolicyRulesConfigurator $rules): void;
    public function configureRole(Role $role): void;
}
