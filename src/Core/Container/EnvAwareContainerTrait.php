<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesCallback;

trait EnvAwareContainerTrait
{
    /**
     * @var ContainerResourcesCallback[]
     */
    private array $resourcesForEnv = [];

    public function resourcesForEnv(string $env): ContainerResourcesCallback|null
    {
        return $this->resourcesForEnv[$env] ?? null;
    }

    public function setResourcesForEnv(string $env, ContainerResourcesCallback $resources): static
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
