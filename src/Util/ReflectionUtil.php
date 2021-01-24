<?php

namespace Dealroadshow\K8S\Framework\Util;

class ReflectionUtil
{
    public static function sameSignature(\ReflectionFunctionAbstract $methodA, \ReflectionFunctionAbstract $methodB): bool
    {
        if (strval($methodA->getReturnType()) !== strval($methodB->getReturnType())) {
            return false;
        }

        return $methodA->getParameters() == $methodB->getParameters();
    }
}
