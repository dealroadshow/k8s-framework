<?php

namespace Dealroadshow\K8S\Framework\Renderer;

interface RendererInterface
{
    public function render(\JsonSerializable $object): string;
}
