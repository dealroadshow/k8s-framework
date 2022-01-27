<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AppGroups
{
    private array $groups;

    public function __construct(string|array $groups)
    {
        if (is_string($groups)) {
            $groups = [$groups];
        }

        $this->groups = $groups;
    }

    public function get(): array
    {
        return $this->groups;
    }
}
