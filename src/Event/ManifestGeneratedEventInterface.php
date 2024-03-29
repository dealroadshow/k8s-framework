<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ManifestGeneratedEventInterface
{
    public function manifest(): ManifestInterface;

    public function apiResource(): APIResourceInterface;
}
