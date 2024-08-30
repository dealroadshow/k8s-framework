<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Affinity\Pod;

use Dealroadshow\K8S\Api\Core\V1\PodAffinityTerm;
use Dealroadshow\K8S\Api\Core\V1\PodAffinityTermList;
use Dealroadshow\K8S\Api\Core\V1\WeightedPodAffinityTerm;
use Dealroadshow\K8S\Api\Core\V1\WeightedPodAffinityTermList;
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
    public function addPreferenceByExpression(PodAffinityExpression $expression, int $weight, string $topologyKey, array $namespaces = null): static
    {
        $term = $this->affinityTermFromExpression($expression, $topologyKey, $namespaces);
        $weightedTerm = new WeightedPodAffinityTerm($term, $weight);
        $this->preferences->add($weightedTerm);

        return $this;
    }

    /**
     * @param array               $labels
     * @param int                 $weight
     * @param string              $topologyKey
     * @param string[]|array|null $namespaces
     *
     * @return $this
     */
    public function addPreferenceByLabels(array $labels, int $weight, string $topologyKey, array $namespaces = null): static
    {
        $term = $this->affinityTermByLabel($labels, $topologyKey, $namespaces);
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
    public function addRequirementByExpression(PodAffinityExpression $expression, string $topologyKey, array $namespaces = null): static
    {
        $term = $this->affinityTermFromExpression($expression, $topologyKey, $namespaces);
        $this->requirements->add($term);

        return $this;
    }

    /**
     * @param array               $labels
     * @param string              $topologyKey
     * @param string[]|array|null $namespaces
     *
     * @return $this
     */
    public function addRequirementByLabels(array $labels, string $topologyKey, array $namespaces = null): static
    {
        $term = $this->affinityTermByLabel($labels, $topologyKey, $namespaces);
        $this->requirements->add($term);

        return $this;
    }

    private function affinityTermFromExpression(PodAffinityExpression $expression, string $topologyKey, array $namespaces = null): PodAffinityTerm
    {
        $selector = $expression->toLabelSelectorRequirement();
        $term = new PodAffinityTerm($topologyKey);
        $term->labelSelector()->matchExpressions()->add($selector);
        if (null !== $namespaces) {
            $term->namespaces()->addAll(array_values($namespaces));
        }

        return $term;
    }

    private function affinityTermByLabel(array $labels, string $topologyKey, array $namespaces = null): PodAffinityTerm
    {
        $term = new PodAffinityTerm($topologyKey);
        $matchLabels = $term->labelSelector()->matchLabels();
        foreach ($labels as $labelKey => $labelValue) {
            $matchLabels->add($labelKey, $labelValue);
        }
        if (null !== $namespaces) {
            $term->namespaces()->addAll(array_values($namespaces));
        }

        return $term;
    }
}
