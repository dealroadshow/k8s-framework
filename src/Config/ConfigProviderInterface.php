<?php

namespace Dealroadshow\K8S\Framework\Config;

interface ConfigProviderInterface
{
    public function config(): array;
}
