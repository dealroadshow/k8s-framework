<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Action;

use Dealroadshow\K8S\Api\Core\V1\LifecycleHandler;

class LifecycleActionConfigurator
{
    use ActionConfiguratorTrait;

    private LifecycleHandler $handler;

    public function __construct(LifecycleHandler $handler)
    {
        $this->handler = $handler;
    }
}
