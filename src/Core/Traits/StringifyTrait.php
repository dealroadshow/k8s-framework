<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Traits;

use Stringable;
use TypeError;

trait StringifyTrait
{
    final protected static function stringify(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_int($value) || is_float($value) || $value instanceof Stringable) {
            return (string)$value;
        }

        $type = gettype($value);
        throw new TypeError(
            sprintf(
                'Value, passed to %s::%s() must be bool, numeric or instance of Stringable, got "%s"',
                static::class,
                'stringify',
                $type === 'object' ? static::class : $type
            )
        );
    }
}
