<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\Proximity\ProxyInterface;

class ClassName
{
    public static function real(object $object): string
    {
        $class = new \ReflectionObject($object);
        if ($class->implementsInterface(ProxyInterface::class)) {
            $class = $class->getParentClass();
        }

        return $class->getName();
    }
}
