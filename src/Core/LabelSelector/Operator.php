<?php

namespace Dealroadshow\K8S\Framework\Core\LabelSelector;

final class Operator
{
    const IN = 'In';
    const NOT_IN = 'NotIn';
    const EXISTS = 'Exists';
    const DOES_NOT_EXIST = 'DoesNotExist';
    const GREATER_THAN = 'Gt';
    const LOWER_THAN = 'Lt';
}
