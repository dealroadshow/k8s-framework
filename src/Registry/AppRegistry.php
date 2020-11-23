<?php

namespace Dealroadshow\K8S\Framework\Registry;

use LogicException;
use Dealroadshow\K8S\Framework\App\AppInterface;

class AppRegistry
{
    /**
     * @var array<string, AppInterface>|AppInterface[]
     */
    private array $apps;

    /**
     * @param array<string, AppInterface>|AppInterface[] $apps
     */
    public function __construct(iterable $apps)
    {
        $this->apps = [];
        foreach ($apps as $app) {
            $appName = $app::name();
            if (!$this->has($appName)) {
                $this->apps[$appName] = $app;

                continue;
            }

            throw new LogicException(
                sprintf(
                    'App name must be unique, but "%s" and "%s" share the same name "%s"',
                    get_class($this->apps[$appName]),
                    get_class($app),
                    $appName
                )
            );
        }
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
     * @return array|string[]
     */
    public function names(): array
    {
        return array_keys($this->apps);
    }
}
