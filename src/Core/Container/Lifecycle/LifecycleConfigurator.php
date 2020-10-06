<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle;

use Dealroadshow\K8S\Data\Lifecycle;
use Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Action\LifecycleActionConfigurator;

class LifecycleConfigurator
{
    private Lifecycle $lifecycle;

    public function __construct(Lifecycle $lifecycle)
    {
        $this->lifecycle = $lifecycle;
    }

    public function preStop(): LifecycleActionConfigurator
    {
        return new LifecycleActionConfigurator($this->lifecycle->preStop());
    }

    public function postStart(): LifecycleActionConfigurator
    {
        return new LifecycleActionConfigurator($this->lifecycle->postStart());
    }
}
