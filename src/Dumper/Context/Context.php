<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Dumper\Context;

class Context implements ContextInterface
{
    private array $includeTags;
    private array $excludeTags;

    public function __construct(array $includeTags, array $excludeTags)
    {
        $this->includeTags = $includeTags;
        $this->excludeTags = $excludeTags;
    }

    public function includeTags(): array
    {
        return $this->includeTags;
    }

    public function excludeTags(): array
    {
        return $this->excludeTags;
    }
}
