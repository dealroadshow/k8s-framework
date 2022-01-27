<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\K8S\Data\Collection\StringMap;

class StringMapProxy extends StringMap
{
    public function __construct(private StringMap $map)
    {
        parent::__construct();
    }

    public function add(string $name, string|bool $value): StringMap
    {
        $value = Str::stringify($value);
        $this->map->add($name, $value);

        return $this;
    }

    public function addAll(array $items): StringMap
    {
        $this->map->addAll($items);

        return $this;
    }

    /**
     * @return string[]
     */
    public function all(): array
    {
        return $this->map->all();
    }

    public function clear(): self
    {
        $this->map->clear();

        return $this;
    }

    public function count(): int
    {
        return $this->map->count();
    }

    public function get(string $name): string
    {
        return $this->map->get($name);
    }

    public function has(string $name): bool
    {
        return $this->map->has($name);
    }

    public function remove(string $name): self
    {
        $this->map->remove($name);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->map->jsonSerialize();
    }

    public static function make(StringMap $map): static
    {
        return new static($map);
    }
}
