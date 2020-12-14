<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\App\AppInterface;

class AppRegistry
{
    /**
     * @var array<string, AppInterface>|AppInterface[]
     */
    private array $apps = [];

    public function add(string $alias, AppInterface $app): void
    {
        if ($this->has($alias)) {
            throw new \InvalidArgumentException(
                sprintf('App with alias "%s" already exists', $alias)
            );
        }

        $this->apps[$alias] = $app;
    }

    public function has(string $alias): bool
    {
        return array_key_exists($alias, $this->apps);
    }

    public function get(string $alias): AppInterface
    {
        if(!$this->has($alias)) {
            throw new \InvalidArgumentException(
                sprintf('App "%s" does not exist', $alias)
            );
        }
        return $this->apps[$alias];
    }

    /**
     * @return string[]
     */
    public function aliases(): array
    {
        return array_keys($this->apps);
    }
}
