<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Config;

interface ConfigAwareInterface
{
    public function setConfig(array $config): void;
}
