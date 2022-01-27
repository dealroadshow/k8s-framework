<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\LabelSelector;

use Dealroadshow\K8S\Data\LabelSelector;

class SelectorConfigurator
{
    private LabelSelector $labelSelector;

    public function __construct(LabelSelector $labelSelector)
    {
        $this->labelSelector = $labelSelector;
    }

    public function addExpression(LabelSelectorExpression $expression): self
    {
        $this->labelSelector->matchExpressions()->add($expression->toLabelSelectorRequirement());

        return $this;
    }

    public function addLabel(string $labelName, string $labelValue): self
    {
        $this->labelSelector->matchLabels()->add($labelName, $labelValue);

        return $this;
    }
}
