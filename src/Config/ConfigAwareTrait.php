<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Config;

trait ConfigAwareTrait
{
    protected array $config = [];

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
