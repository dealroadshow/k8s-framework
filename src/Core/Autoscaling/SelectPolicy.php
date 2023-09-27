<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling;

enum SelectPolicy: string
{
    case Min = 'Min';
    case Max = 'Max';
    case Disabled = 'Disabled';
}
