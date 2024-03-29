<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Renderer;

use Symfony\Component\Yaml\Yaml;

class YamlRenderer extends AbstractRenderer
{
    public function render(\JsonSerializable|array $object): string
    {
        $data = $this->withoutNullValues($object);
        $inline = $this->calcDumpInline($data);

        return Yaml::dump($data, $inline, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }

    public function fileExtension(): string
    {
        return '.yaml';
    }

    private function calcDumpInline($array): int
    {
        $depth = $this->calcDepth($array);

        return max(7, $depth - 1);
    }

    private function calcDepth(array $array): int
    {
        $maxDepth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->calcDepth($value) + 1;
                if ($depth > $maxDepth) {
                    $maxDepth = $depth;
                }
            }
        }

        return $maxDepth;
    }
}
