<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Affinity;

use Dealroadshow\K8S\Data\Affinity;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\Node\NodeAffinityBuilder;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\Pod\PodAffinityBuilder;

class AffinityConfigurator
{
    private Affinity $affinity;

    public function __construct(Affinity $affinity)
    {
        $this->affinity = $affinity;
    }

    public function nodeAffinity(): NodeAffinityBuilder
    {
        return new NodeAffinityBuilder($this->affinity->nodeAffinity());
    }

    public function podAffinity(): PodAffinityBuilder
    {
        $podAffinity = $this->affinity->podAffinity();
        $preferences = $podAffinity->preferredDuringSchedulingIgnoredDuringExecution();
        $requirements = $podAffinity->requiredDuringSchedulingIgnoredDuringExecution();

        return new PodAffinityBuilder($preferences, $requirements);
    }

    public function podAntiAffinity(): PodAffinityBuilder
    {
        $podAffinity = $this->affinity->podAntiAffinity();
        $preferences = $podAffinity->preferredDuringSchedulingIgnoredDuringExecution();
        $requirements = $podAffinity->requiredDuringSchedulingIgnoredDuringExecution();

        return new PodAffinityBuilder($preferences, $requirements);
    }
}
