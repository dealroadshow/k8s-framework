<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\App\AppInterface;

class AppRegistry
{
    /**
     * @var array<string, AppInterface>|AppInterface[]
     */
    private array $apps = [];

    public function add(string $alias, AppInterface $app)
    {
        if ($this->has($alias)) {
            throw new \InvalidArgumentException(
                sprintf('App with alias "%s" already exists', $alias)
            );
        }

        $this->apps[$alias] = $app;
    }

    public function has(string $appName): bool
    {
        return array_key_exists($appName, $this->apps);
    }

    public function get(string $appName): AppInterface
    {
        if(!$this->has($appName)) {
            throw new \InvalidArgumentException(
                sprintf('App "%s" does not exist', $appName)
            );
        }
        return $this->apps[$appName];
    }

    /**
     * @return string[]
     */
    public function names(): array
    {
        return array_keys($this->apps);
    }
}
