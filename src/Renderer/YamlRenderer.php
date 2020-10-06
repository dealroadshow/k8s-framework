<?php

namespace Dealroadshow\K8S\Framework\Renderer;

use Symfony\Component\Yaml\Yaml;

class YamlRenderer extends AbstractRenderer
{
    public function render(\JsonSerializable $object): string
    {
        $data = $this->withoutNullValues($object);

        return Yaml::dump($data, 7, 2);
    }
}
