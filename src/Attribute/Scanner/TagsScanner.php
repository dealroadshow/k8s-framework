<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Attribute\Scanner;

use Dealroadshow\K8S\Framework\Attribute\Tags;
use ReflectionClass;

class TagsScanner
{
    /**
     * @param object $object
     * @return string[]
     * @throws \ReflectionException
     */
    public static function scan(object $object): array
    {
        $reflectionClass = new ReflectionClass($object::class);
        $attributes = $reflectionClass->getAttributes(Tags::class);
        $tags = [];
        foreach ($attributes as $attribute) {
            /** @var Tags $tagsAttribute */
            $tagsAttribute = $attribute->newInstance();
            $tags = array_merge($tags, $tagsAttribute->get());
        }
        $tags = array_unique($tags);

        return array_values($tags);
    }
}
