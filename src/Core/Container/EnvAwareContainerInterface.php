<?php

namespace Dealroadshow\K8S\Framework\Core\Container;

use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesCallback;

interface EnvAwareContainerInterface extends ContainerInterface
{
    public function resourcesForEnv(string $env): ResourcesCallback|null;
    public function setResourcesForEnv(string $env, ResourcesCallback $resources): static;
}
