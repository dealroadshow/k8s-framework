<?php

namespace Dealroadshow\K8S\Framework\Renderer;

abstract class AbstractRenderer implements RendererInterface
{
    protected function withoutNullValues(\JsonSerializable|array $object): array
    {
        $json = json_encode($object);
        $data = json_decode($json, true);

        $data = array_filter($data, fn(mixed $elem) => null !== $elem);

        array_walk($data, [$this, 'walkFunction']);

        $data = array_filter($data);

        return $data;
    }

    private function walkFunction(&$value)
    {
        if (\is_array($value)) {
            \array_walk($value, [$this, 'walkFunction']);

            $value = array_filter($value, fn(mixed $elem) => null !== $elem);
        }
    }
}
