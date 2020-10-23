<?php

namespace Dealroadshow\K8S\Framework\Dumper\Context;

interface ContextInterface
{
    public function includeTags(): array;
    public function excludeTags(): array;
}