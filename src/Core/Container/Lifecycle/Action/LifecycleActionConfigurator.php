<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Action;

use Dealroadshow\K8S\Data\Handler;

class LifecycleActionConfigurator
{
    use ActionConfiguratorTrait;

    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }
}
