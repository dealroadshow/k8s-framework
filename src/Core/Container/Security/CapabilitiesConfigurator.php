<?php

declare(strict_types=1);

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
    public function add(array $capabilities): void
    {
        $this->capabilities->add()->addAll(array_values($capabilities));
    }

    /**
     * @param array|string[] $capabilities
     */
    public function drop(array $capabilities): void
    {
        $this->capabilities->drop()->addAll(array_values($capabilities));
    }
}
