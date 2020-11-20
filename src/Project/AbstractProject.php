<?php

namespace Dealroadshow\K8S\Framework\Project;

use Dealroadshow\K8S\Framework\Config\ConfigAwareTrait;

abstract class AbstractProject implements ProjectInterface
{
    use ConfigAwareTrait;

    public function config(): array
    {
        return $this->config;
    }
}
