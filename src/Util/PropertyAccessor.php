<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

final class PropertyAccessor
{
    private static \Closure|null $getter = null;
    private static \Closure|null $setter = null;

    public static function get(object $object, string $propertyName): mixed
    {
        return self::getterClosure()->call($object, $propertyName);
    }

    public static function set(object $object, string $propertyName, mixed $propertyValue): void
    {
        self::setterClosure()->call($object, $propertyName, $propertyValue);
    }

    /**
     * @noinspection
     * Used only as closure to get property value
     */
    private static function getterClosure(): \Closure
    {
        self::$getter ??= fn (string $propertyName) => $this->$propertyName;

        return self::$getter;
    }

    /**
     * Used only as closure to set property value
     */
    private static function setterClosure(): \Closure
    {
        self::$setter ??= function (string $propertyName, mixed $propertyValue): void {
            $this->$propertyName = $propertyValue;
        };

        return self::$setter;
    }
}
