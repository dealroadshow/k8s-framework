<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Toleration;

enum TolerationOperator: string
{
    case Exists = 'Exists';
    case Equal = 'Equal';
}
