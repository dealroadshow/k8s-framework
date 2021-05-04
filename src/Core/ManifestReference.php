<?php

namespace Dealroadshow\K8S\Framework\Core;

class ManifestReference
{
    public function __construct(private string $appAlias, private string $className)
    {
    }

    public function appAlias(): string
    {
        return $this->appAlias;
    }

    public function className(): string
    {
        return $this->className;
    }
}
