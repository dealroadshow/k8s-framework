<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator;

use Dealroadshow\K8S\Api\Rbac\V1\PolicyRule;
use Dealroadshow\K8S\Framework\Core\Rbac\Verb;

readonly class PolicyRuleConfigurator
{
    public function __construct(private PolicyRule $rule)
    {
    }

    public function addApiGroups(string ...$groups): static
    {
        $this->rule->apiGroups()->addAll($groups);

        return $this;
    }

    public function addNonResourceURLs(string ...$urls): static
    {
        $this->rule->nonResourceURLs()->addAll($urls);

        return $this;
    }

    public function addResourceNames(string ...$names): static
    {
        $this->rule->resourceNames()->addAll($names);

        return $this;
    }

    public function addResources(string ...$resources): static
    {
        $this->rule->resources()->addAll($resources);

        return $this;
    }

    public function addVerbs(Verb ...$verbs): static
    {
        $this->rule->verbs()->addAll(array_map(fn (Verb $verb) => $verb->value, $verbs));

        return $this;
    }

    public function rule(): PolicyRule
    {
        return $this->rule;
    }
}
