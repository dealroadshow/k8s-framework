<?php

declare(strict_types=1);

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

    public function all(): array
    {
        return $this->apps;
    }

    /**
     * @return string[]
     */
    public function aliases(): array
    {
        return array_keys($this->apps);
    }

    /**
     * @param string $appClass
     *
     * @return AppInterface[]
     */
    public function allAppsByClass(string $appClass): iterable
    {
        foreach ($this->apps as $alias => $app) {
            if ($app instanceof $appClass) {
                yield $alias => $app;
            }
        }
    }

    /**
     * @return string[]
     */
    public function classes(): array
    {
        $classes = array_map(fn (AppInterface $app) => $app::class, $this->apps);

        return array_values(array_unique($classes));
    }

    public function has(string $alias): bool
    {
        return array_key_exists($alias, $this->apps);
    }

    public function get(string $alias): AppInterface
    {
        if (!$this->has($alias)) {
            throw new \InvalidArgumentException(
                sprintf('App "%s" does not exist', $alias)
            );
        }
        return $this->apps[$alias];
    }
}
