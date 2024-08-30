<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Apps\V1\StatefulSet;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\StatefulSet\StatefulSetInterface;

readonly class StatefulSetGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.stateful_set';

    public function __construct(private StatefulSetInterface $manifest, private StatefulSet $sts, private AppInterface $app)
    {
    }

    public function manifest(): StatefulSetInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->sts;
    }

    public function statefulSet(): StatefulSet
    {
        return $this->sts;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
