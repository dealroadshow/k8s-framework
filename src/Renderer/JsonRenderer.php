<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Renderer;

class JsonRenderer extends AbstractRenderer
{
    public function render(\JsonSerializable|array $object): string
    {
        return \json_encode($this->renderAsArray($object));
    }

    public function fileExtension(): string
    {
        return '.json';
    }

    public function renderAsArray(\JsonSerializable|array $object): array
    {
        return $this->withoutNullValues($object);
    }
}
