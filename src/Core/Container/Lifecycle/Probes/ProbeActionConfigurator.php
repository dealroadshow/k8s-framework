<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes;

use Dealroadshow\K8S\Api\Core\V1\Probe;
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
