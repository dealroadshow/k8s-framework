<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Toleration;

enum TolerationEffect: string
{
    case NoSchedule = 'NoSchedule';
    case PreferNoSchedule = 'PreferNoSchedule';
    case NoExecute = 'NoExecute';
}
