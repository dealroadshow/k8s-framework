<?php


namespace Dealroadshow\K8S\Framework\Annotation;

use ReflectionClass;

class TagsScanner
{
    /**
     * @param object $object
     * @return string[]
     * @throws \ReflectionException
     */
    public static function tags(object $object): array
    {
        $reflectionClass = new ReflectionClass($object::class);
        $attributes = $reflectionClass->getAttributes(Tags::class);
        $tags = [];
        foreach($attributes as $attribute) {
            /** @var Tags $tagsAttribute */
            $tagsAttribute = $attribute->newInstance();
            $tags = array_merge($tags, $tagsAttribute->getTags());
        }
        $tags = array_unique($tags);
        return array_values($tags);
    }
}