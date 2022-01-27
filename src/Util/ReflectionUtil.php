<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

class ReflectionUtil
{
    public static function sameSignature(\ReflectionFunctionAbstract $methodA, \ReflectionFunctionAbstract $methodB, bool $ignoreNullsInReturnTypes = true): bool
    {
        $returnTypeA = (string)$methodA->getReturnType();
        $returnTypeB = (string)$methodB->getReturnType();
        if ($ignoreNullsInReturnTypes) {
            $returnTypeA = ltrim($returnTypeA, '?');
            $returnTypeB = ltrim($returnTypeA, '?');
            $returnTypeA = str_replace('|null', '', $returnTypeA);
            $returnTypeB = str_replace('|null', '', $returnTypeB);
        }

        if ($returnTypeA !== $returnTypeB) {
            return false;
        }

        return $methodA->getParameters() == $methodB->getParameters();
    }
}
