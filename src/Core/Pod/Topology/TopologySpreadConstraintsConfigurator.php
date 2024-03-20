<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Topology;

use Dealroadshow\K8S\Data\Collection\TopologySpreadConstraintList;
use Dealroadshow\K8S\Data\TopologySpreadConstraint;

readonly class TopologySpreadConstraintsConfigurator
{
    public function __construct(private TopologySpreadConstraintList $constraints)
    {
    }

    public function add(int $maxSkew, string $topologyKey, WhenUnsatisfiable $whenUnsatisfiable): TopologySpreadConstraintConfigurator
    {
        $constraint = new TopologySpreadConstraint($maxSkew, $topologyKey, $whenUnsatisfiable->value);
        $this->constraints->add($constraint);

        return new TopologySpreadConstraintConfigurator($constraint);
    }
}
