<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Batch\V1\CronJob;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\CronJob\CronJobInterface;

readonly class CronJobGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.cronJob';

    public function __construct(private CronJobInterface $manifest, private CronJob $cronJob, private AppInterface $app)
    {
    }

    public function manifest(): CronJobInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->cronJob;
    }

    public function cronJob(): CronJob
    {
        return $this->cronJob;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
