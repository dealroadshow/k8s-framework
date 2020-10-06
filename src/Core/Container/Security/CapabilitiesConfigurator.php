<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Security;

use Dealroadshow\K8S\Data\Capabilities;

class CapabilitiesConfigurator
{
    private Capabilities $capabilities;

    public function __construct(Capabilities $capabilities)
    {
        $this->capabilities = $capabilities;
    }

    /**
     * @param array|string[] $capabilities
     */
    public function add(array $capabilities)
    {
        $this->capabilities->add()->addAll(array_values($capabilities));
    }

    /**
     * @param array|string[] $capabilities
     */
    public function drop(array $capabilities)
    {
        $this->capabilities->drop()->addAll(array_values($capabilities));
    }
}
