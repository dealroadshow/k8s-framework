<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume;

use Dealroadshow\K8S\Data\Collection\VolumeList;
use Dealroadshow\K8S\Data\Volume;

class VolumesMap
{
    /**
     * @var array<string, Volume>|Volume[]
     */
    private array $volumes = [];

    private function __construct(VolumeList $list)
    {
        foreach ($list->all() as $volume) {
            $this->volumes[$volume->getName()] = $volume;
        }
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->volumes);
    }

    public function get(string $name): Volume
    {
        return $this->volumes[$name];
    }

    /**
     * @return array|string[]
     */
    public function names(): array
    {
        return array_map(fn (Volume $volume) => $volume->getName(), array_values($this->volumes));
    }

    public static function fromVolumeList(VolumeList $list): self
    {
        return new self($list);
    }
}
