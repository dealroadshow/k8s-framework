<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator;

use Dealroadshow\K8S\Data\AggregationRule;
use Dealroadshow\K8S\Data\LabelSelector;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;

readonly class AggregationRuleConfigurator
{
    public function __construct(private AggregationRule $rule)
    {
    }

    public function addClusterRoleSelector(): SelectorConfigurator
    {
        $selector = new LabelSelector();
        $this->rule->clusterRoleSelectors()->add($selector);

        return new SelectorConfigurator($selector);
    }
}
