<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Topology;

final readonly class WellKnownTopologyKeys
{
    public const HOSTNAME = 'kubernetes.io/hostname';
    public const ZONE = 'topology.kubernetes.io/zone';
    public const REGION = 'topology.kubernetes.io/region';
}
