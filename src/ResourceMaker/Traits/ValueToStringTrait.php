<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker\Traits;

trait ValueToStringTrait
{
    private function valueToString(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string)$value;
    }
}
