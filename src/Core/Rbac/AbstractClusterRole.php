<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac;

use Dealroadshow\K8S\Api\Rbac\V1\ClusterRole;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\AggregationRuleConfigurator;

abstract class AbstractClusterRole extends AbstractManifest implements ClusterRoleInterface
{
    public function aggregationRule(AggregationRuleConfigurator $rule): void
    {
    }

    public function configureClusterRole(ClusterRole $clusterRole): void
    {
    }

    public static function apiVersion(): string
    {
        return ClusterRole::API_VERSION;
    }

    public static function kind(): string
    {
        return ClusterRole::KIND;
    }
}
