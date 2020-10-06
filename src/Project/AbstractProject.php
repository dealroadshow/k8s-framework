<?php

namespace Dealroadshow\K8S\Framework\Project;

abstract class AbstractProject implements ProjectInterface
{
    protected string $env;

    public function setEnv(string $env): void
    {
        $this->env = $env;
    }
}
