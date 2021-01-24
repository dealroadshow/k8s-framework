<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesCallback;

trait EnvAwareContainerTrait
{
    /**
     * @var ContainerResourcesCallback[]
     */
    private array $resourcesForEnv = [];

    /**
     * @var int[]
     */
    private array $replicasForEnv = [];

    public function replicasForEnv(string $env): int|null
    {
        return $this->replicasForEnv[$env] ?? null;
    }

    public function setReplicasForEnv(string $env, int $replicas): static
    {
        if (isset($this->replicasForEnv[$env])) {
            throw new \LogicException(
                sprintf(
                    'Replicas for env "%s" for class "%s" already set',
                    $env,
                    get_class($this)
                )
            );
        }
        $this->replicasForEnv[$env] = $replicas;

        return $this;
    }

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
