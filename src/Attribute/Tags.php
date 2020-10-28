<?php

namespace Dealroadshow\K8S\Framework\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Tags
{
    /**
     * @var string[]
     */
    private array $tags;

    public function __construct(string ...$tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->tags;
    }
}
