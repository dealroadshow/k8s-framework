<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Affinity\Pod;

use Dealroadshow\K8S\Data\Collection\PodAffinityTermList;
use Dealroadshow\K8S\Data\Collection\WeightedPodAffinityTermList;
use Dealroadshow\K8S\Data\PodAffinityTerm;
use Dealroadshow\K8S\Data\WeightedPodAffinityTerm;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\PodAffinityExpression;

class PodAffinityBuilder
{
    private WeightedPodAffinityTermList $preferences;
    private PodAffinityTermList $requirements;

    public function __construct(WeightedPodAffinityTermList $preferences, PodAffinityTermList $requirements)
    {
        $this->preferences = $preferences;
        $this->requirements = $requirements;
    }

    /**
     * @param PodAffinityExpression $expression
     * @param int                   $weight
     * @param string                $topologyKey
     * @param string[]|array|null   $namespaces
     *
     * @return $this
     */
    public function addPreferenceByExpression(PodAffinityExpression $expression, int $weight, string $topologyKey, array $namespaces = null): self
    {
        $term = $this->affinityTermFromExpression($expression, $topologyKey, $namespaces);
        $weightedTerm = new WeightedPodAffinityTerm($term, $weight);
        $this->preferences->add($weightedTerm);

        return $this;
    }

    /**
     * @param string              $labelKey
     * @param string              $labelValue
     * @param int                 $weight
     * @param string              $topologyKey
     * @param string[]|array|null $namespaces
     *
     * @return $this
     */
    public function addPreferenceByLabel(string $labelKey, string $labelValue, int $weight, string $topologyKey, array $namespaces = null)
    {
        $term = $this->affinityTermByLabel($labelKey, $labelValue, $topologyKey, $namespaces);
        $weightedTerm = new WeightedPodAffinityTerm($term, $weight);
        $this->preferences->add($weightedTerm);

        return $this;
    }

    /**
     * @param PodAffinityExpression $expression
     * @param string                $topologyKey
     * @param string[]|array|null   $namespaces
     *
     * @return $this
     */
    public function addRequirementByExpression(PodAffinityExpression $expression, string $topologyKey, array $namespaces = null): self
    {
        $term = $this->affinityTermFromExpression($expression, $topologyKey, $namespaces);
        $this->requirements->add($term);

        return $this;
    }

    /**
     * @param string              $labelKey
     * @param string              $labelValue
     * @param string              $topologyKey
     * @param string[]|array|null $namespaces
     *
     * @return $this
     */
    public function addRequirementByLabel(string $labelKey, string $labelValue, string $topologyKey, array $namespaces = null)
    {
        $term = $this->affinityTermByLabel($labelKey, $labelValue, $topologyKey, $namespaces);
        $this->requirements->add($term);

        return $this;
    }

    private function affinityTermFromExpression(PodAffinityExpression $expression, string $topologyKey, ?array $namespaces = null): PodAffinityTerm
    {
        $selector = $expression->toLabelSelectorRequirement();
        $term = new PodAffinityTerm($topologyKey);
        $term->labelSelector()->matchExpressions()->add($selector);
        if (null !== $namespaces) {
            $term->namespaces()->addAll(array_values($namespaces));
        }

        return $term;
    }

    private function affinityTermByLabel(string $labelKey, string $labelValue, string $topologyKey, ?array $namespaces = null): PodAffinityTerm
    {
        $term = new PodAffinityTerm($topologyKey);
        $term->labelSelector()->matchLabels()->add($labelKey, $labelValue);
        if (null !== $namespaces) {
            $term->namespaces()->addAll(array_values($namespaces));
        }

        return $term;
    }
}
