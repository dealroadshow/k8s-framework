<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

trait ResourcesForEnvTrait
{
    /**
     * @var ContainerResourcesCallback[]
     */
    private array $resourcesForEnv = [];

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

    public function resourcesForEnv(string $env): ContainerResourcesCallback|null
    {
        return $this->resourcesForEnv[$env] ?? null;
    }
}
