<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Topology;

enum NodePolicy: string
{
    case Honor = 'Honor';
    case Ignore = 'Ignore';
}
