<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesCallback;

interface EnvAwareContainerInterface extends ContainerInterface
{
    public function setResourcesForEnv(string $env, ContainerResourcesCallback $resources): static;
    public function resourcesForEnv(string $env): ContainerResourcesCallback|null;
}
