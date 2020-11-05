<?php

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\App\AppInterface;

interface AppAwareInterface
{
    public function setApp(AppInterface $app): void;
    public function app(): AppInterface;
}
