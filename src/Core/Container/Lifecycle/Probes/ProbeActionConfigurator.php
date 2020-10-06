<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes;

use Dealroadshow\K8S\Data\Probe;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Action\ActionConfiguratorTrait;

class ProbeActionConfigurator
{
    use ActionConfiguratorTrait;

    private Probe $handler;

    public function __construct(Probe $handler)
    {
        $this->handler = $handler;
    }
}