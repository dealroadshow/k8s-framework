<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Affinity\Node;

use Dealroadshow\K8S\Data\NodeAffinity;
use Dealroadshow\K8S\Data\NodeSelectorTerm;
use Dealroadshow\K8S\Data\PreferredSchedulingTerm;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\NodeAffinityExpression;

class NodeAffinityBuilder
{
    private NodeAffinity $affinity;

    public function __construct(NodeAffinity $affinity)
    {
        $this->affinity = $affinity;
    }

    public function addPreference(NodeAffinityExpression $rule, int $preferenceWeight): self
    {
        $preferences = $this->affinity->preferredDuringSchedulingIgnoredDuringExecution();
        $term = new PreferredSchedulingTerm($preferenceWeight);
        $preferences->add($term);
        $selector = $term->preference();

        $list = NodeAffinityExpression::TARGET_FIELD === $rule->target()
            ? $selector->matchFields()
            : $selector->matchExpressions();
        $requirement = $rule->toNodeSelectorRequirement();
        $list->add($requirement);

        return $this;
    }

    public function addRequirement(NodeAffinityExpression $rule): self
    {
        $requirements = $this->affinity->requiredDuringSchedulingIgnoredDuringExecution();
        $selector = new NodeSelectorTerm();
        $requirements->nodeSelectorTerms()->add($selector);

        $list = NodeAffinityExpression::TARGET_FIELD === $rule->target()
            ? $selector->matchFields()
            : $selector->matchExpressions();
        $requirement = $rule->toNodeSelectorRequirement();
        $list->add($requirement);

        return $this;
    }
}
