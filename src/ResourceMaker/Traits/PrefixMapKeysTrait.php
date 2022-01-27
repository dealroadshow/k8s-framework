<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker\Traits;

use Dealroadshow\K8S\Data\Collection\StringMap;

trait PrefixMapKeysTrait
{
    private function prefixMapKeys(string $prefix, StringMap $map): void
    {
        foreach ($map->all() as $key => $value) {
            $newKey = $prefix.$key;
            $map->remove($key);
            $map->add($newKey, $value);
        }
    }
}
