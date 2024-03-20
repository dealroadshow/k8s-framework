<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Topology;

enum WhenUnsatisfiable: string
{
    case DoNotSchedule = 'DoNotSchedule';
    case ScheduleAnyway = 'ScheduleAnyway';
}
