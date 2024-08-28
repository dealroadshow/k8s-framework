<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator;

use Dealroadshow\K8S\Data\Collection\PolicyRuleList;
use Dealroadshow\K8S\Data\PolicyRule;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\PolicyRuleConfigurator;

readonly class PolicyRulesConfigurator
{
    public function __construct(private PolicyRuleList $rules)
    {
    }

    public function add(): PolicyRuleConfigurator
    {
        $rule = new PolicyRule();
        $this->rules->add($rule);

        return new PolicyRuleConfigurator($rule);
    }
}
