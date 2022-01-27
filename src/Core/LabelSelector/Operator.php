<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\LabelSelector;

final class Operator
{
    public const IN = 'In';
    public const NOT_IN = 'NotIn';
    public const EXISTS = 'Exists';
    public const DOES_NOT_EXIST = 'DoesNotExist';
    public const GREATER_THAN = 'Gt';
    public const LOWER_THAN = 'Lt';
}
