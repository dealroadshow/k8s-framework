<?php

namespace Dealroadshow\K8S\Framework\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AppGroups
{
    private array $groups;

    public function __construct(string ...$groups)
    {
        $this->groups = $groups;
    }

    public function get(): array
    {
        return $this->groups;
    }
}
