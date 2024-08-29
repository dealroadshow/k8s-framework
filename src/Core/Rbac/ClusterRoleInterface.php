<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\Api\Rbac\V1\ClusterRole;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\AggregationRuleConfigurator;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\PolicyRulesConfigurator;

interface ClusterRoleInterface extends ManifestInterface
{
    public function aggregationRule(AggregationRuleConfigurator $rule): void;
    public function rules(PolicyRulesConfigurator $rules): void;
    public function configureClusterRole(ClusterRole $clusterRole): void;
}
