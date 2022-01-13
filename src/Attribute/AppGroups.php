<?php

namespace Dealroadshow\K8S\Framework\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AppGroups
{
    public function __construct(private array $groups)
    {
    }

    public function get(): array
    {
        return $this->groups;
    }
}
