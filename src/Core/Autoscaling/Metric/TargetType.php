<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling\Metric;

enum TargetType: string
{
    case Utilization = 'Utilization';
    case Value = 'Value';
    case AverageValue = 'AverageValue';
}
