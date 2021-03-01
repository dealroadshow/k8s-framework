<?php

namespace Dealroadshow\K8S\Framework\Renderer;

class JsonRenderer extends AbstractRenderer
{
    public function render(\JsonSerializable|array $object): string
    {
        $data = $this->withoutNullValues($object);

        return \json_encode($data);
    }
}
