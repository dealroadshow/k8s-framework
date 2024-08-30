<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Rbac\V1\ClusterRole;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\ClusterRoleInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\AggregationRuleConfigurator;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\PolicyRulesConfigurator;

class ClusterRoleMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return ClusterRoleInterface::class;
    }

    protected function makeResource(ManifestInterface|ClusterRoleInterface $manifest, AppInterface $app): ClusterRole
    {
        $role = new ClusterRole();
        $app->metadataHelper()->configureMeta($manifest, $role);
        $rulesConfigurator = new PolicyRulesConfigurator($role->rules());
        $manifest->rules($rulesConfigurator);
        $aggregationRuleConfigurator = new AggregationRuleConfigurator($role->aggregationRule());
        $manifest->aggregationRule($aggregationRuleConfigurator);
        $manifest->configureClusterRole($role);

        return $role;
    }
}
