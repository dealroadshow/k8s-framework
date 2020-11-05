<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;

trait AppAwareTrait
{
    private AppInterface $app;

    public function setApp(AppInterface $app): void
    {
        $this->app = $app;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
