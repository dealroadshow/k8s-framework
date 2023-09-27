<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling\Metric;

enum SourceType: string
{
    case ContainerResource = 'ContainerResource';
    case External = 'External';
    case Object = 'Object';
    case Pods = 'Pods';
    case Resource = 'Resource';
}
