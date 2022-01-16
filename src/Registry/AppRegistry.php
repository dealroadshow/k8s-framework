<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\App\GroupAwareAppInterface;
use Dealroadshow\K8S\Framework\Attribute\AppGroups;

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
        $classes = array_map(fn (AppInterface $app) => get_class($app), $this->apps);

        return array_values(array_unique($classes));
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

    public function filterByGroups(array $groups, $discardNonGrouped = true): array
    {
        if (empty($groups)) {
            return $discardNonGrouped ? [] : $this->apps;
        }

        return array_filter($this->apps, function (AppInterface $app) use ($groups, $discardNonGrouped) {
            if ($app instanceof GroupAwareAppInterface) {
                foreach ($groups as $group) {
                    if ($app->belongsToGroup($group)) {
                        return true;
                    }
                }

                return false;
            }

            $class = new \ReflectionObject($app);
            $reflectionAttributes = $class->getAttributes(AppGroups::class);
            if (0 === count($reflectionAttributes)) {
                return !$discardNonGrouped;
            }
            if (count($reflectionAttributes) > 1) {
                throw new \LogicException(sprintf('App class "%s" has more than one "%s" attribute, which is forbidden', $app::class, AppGroups::class));
            }

            /** @var AppGroups $attribute */
            $attribute = $reflectionAttributes[0]->newInstance();

            return count(array_intersect($groups, $attribute->get())) > 0;
        });
    }
}
