<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Rbac\Role;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\PolicyRulesConfigurator;
use Dealroadshow\K8S\Framework\Core\Rbac\RoleInterface;

class RoleMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return RoleInterface::class;
    }

    protected function makeResource(ManifestInterface|RoleInterface $manifest, AppInterface $app): Role
    {
        $role = new Role();
        $app->metadataHelper()->configureMeta($manifest, $role);
        $rulesConfigurator = new PolicyRulesConfigurator($role->rules());
        $manifest->rules($rulesConfigurator);
        $manifest->configureRole($role);

        return $role;
    }
}
