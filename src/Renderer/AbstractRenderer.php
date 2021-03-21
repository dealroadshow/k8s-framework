<?php

namespace Dealroadshow\K8S\Framework\Renderer;

abstract class AbstractRenderer implements RendererInterface
{
    protected function withoutNullValues(\JsonSerializable|array $object): array
    {
        $json = json_encode($object);
        $data = json_decode($json, true);

        $data = array_filter($data, [$this, 'arrayFilterCallback'], ARRAY_FILTER_USE_BOTH);

        array_walk($data, [$this, 'walkFunction']);

        $data = array_filter($data, [$this, 'arrayFilterCallback'], ARRAY_FILTER_USE_BOTH);

        return $data;
    }

    private function walkFunction(&$value)
    {
        if (\is_array($value)) {
            \array_walk($value, [$this, 'walkFunction']);

            $value = \array_filter($value, [$this, 'arrayFilterCallback'], ARRAY_FILTER_USE_BOTH);
        }
    }

    private function arrayFilterCallback(mixed $value, string|int $key): bool
    {
        if ('emptyDir' === $key) {
            return true; // Special case
        }

        return !in_array($value, [null, []], true);
    }
}
