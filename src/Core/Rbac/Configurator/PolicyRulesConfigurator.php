<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator;

use Dealroadshow\K8S\Api\Rbac\V1\PolicyRule;
use Dealroadshow\K8S\Api\Rbac\V1\PolicyRuleList;

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
