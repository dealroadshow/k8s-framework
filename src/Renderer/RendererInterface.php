<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Renderer;

interface RendererInterface
{
    public function render(\JsonSerializable|array $object): string;
}
