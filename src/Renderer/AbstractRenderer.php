<?php

namespace Dealroadshow\K8S\Framework\Renderer;

abstract class AbstractRenderer implements RendererInterface
{
    public function __construct(protected FilteringService $filteringService)
    {
    }

    protected function withoutNullValues(\JsonSerializable|array $object): array
    {
        $json = json_encode($object);
        $data = json_decode($json, true);

        $data = $this->filteringService->filterArray($data);

        array_walk($data, [$this, 'walkFunction']);

        return $this->filteringService->filterArray($data);
    }

    private function walkFunction(&$value)
    {
        if (\is_array($value)) {
            \array_walk($value, [$this, 'walkFunction']);

            $value = $this->filteringService->filterArray($value);
        }
    }
}
