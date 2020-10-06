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
            $appName = $app->name();
            if (!$this->has($appName)) {
                $this->apps[$app->name()] = $app;

                continue;
            }
            if ($this->get($appName) === $app) {
                // Few projects may depend on the same app
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
        return $this->apps[$appName];
    }
}
