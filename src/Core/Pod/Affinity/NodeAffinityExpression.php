<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Affinity;

use Dealroadshow\K8S\Data\NodeSelectorRequirement;
use Dealroadshow\K8S\Framework\Core\LabelSelector\Operator;

class NodeAffinityExpression extends PodAffinityExpression
{
    public function toNodeSelectorRequirement(): NodeSelectorRequirement
    {
        $requirement = new NodeSelectorRequirement($this->key, $this->operator());
        if (null !== $this->values) {
            $requirement->values()->addAll($this->values);
        }

        return $requirement;
    }

    public function greaterThan(int $value): self
    {
        $this->ensureImmutableOperator();
        $this->operator = Operator::GREATER_THAN;
        $this->values = [$value];

        return $this;
    }

    public function lowerThan(int $value): self
    {
        $this->ensureImmutableOperator();
        $this->operator = Operator::LOWER_THAN;
        $this->values = [$value];

        return $this;
    }
}
