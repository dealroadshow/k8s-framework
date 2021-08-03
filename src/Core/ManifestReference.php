<?php

namespace Dealroadshow\K8S\Framework\Core;

class ManifestReference
{
    public function __construct(private string $appAlias, private string $className, private string|null $apiGroup = null)
    {
    }

    public function appAlias(): string
    {
        return $this->appAlias;
    }

    public function apiGroup(): string|null
    {
        return $this->apiGroup;
    }

    public function className(): string
    {
        return $this->className;
    }
}
