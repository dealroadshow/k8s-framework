<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesCallback;

interface EnvAwareContainerInterface extends ContainerInterface
{
    public function replicasForEnv(string $env): int|null;
    public function setReplicasForEnv(string $env, int $replicas): static;

    public function resourcesForEnv(string $env): ContainerResourcesCallback|null;
    public function setResourcesForEnv(string $env, ContainerResourcesCallback $resources): static;
}
