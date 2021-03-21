<?php

namespace Dealroadshow\K8S\Framework\Renderer;

class FilteringService
{
    public function filterArray(array $array): array
    {
        $parent = $array; // copy argument to new array
        return array_filter($array, function(mixed $value, int|string $key) use ($parent): bool {
            if ('emptyDir' === $key && 1 === count($parent)) {
                return true; // Special case
            }

            return !in_array($value, [null, []], true);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
