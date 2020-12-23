<?php

namespace Dealroadshow\K8S\Framework\Util;

use ProxyManager\Proxy\AccessInterceptorInterface;

class ClassName
{
    public static function real(object $object): string
    {
        $class = new \ReflectionObject($object);
        if ($class->implementsInterface(AccessInterceptorInterface::class)) {
            $class = $class->getParentClass();
        }

        return $class->getName();
    }
}
