<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesCallback;

trait EnvAwareContainerTrait
{
    /**
     * @var ResourcesCallback[]
     */
    private array $resourcesForEnv = [];

    public function resourcesForEnv(string $env): ResourcesCallback|null
    {
        return $this->resourcesForEnv[$env] ?? null;
    }

    public function setResourcesForEnv(string $env, ResourcesCallback $resources): static
    {
        if (isset($this->resourcesForEnv[$env])) {
            throw new \LogicException(
                sprintf(
                    'Resources for env "%s" for class "%s" already set',
                    $env,
                    get_class($this)
                )
            );
        }
        $this->resourcesForEnv[$env] = $resources;

        return $this;
    }
}
