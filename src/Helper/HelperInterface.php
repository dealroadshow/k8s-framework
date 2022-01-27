<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Helper;

use Dealroadshow\K8S\Framework\App\AppInterface;

interface HelperInterface
{
    public function setApp(AppInterface $app): void;
}
