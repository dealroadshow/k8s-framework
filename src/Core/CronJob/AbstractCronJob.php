<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\CronJob;

use Dealroadshow\K8S\Api\Batch\V1\CronJob;
use Dealroadshow\K8S\Framework\Core\Job\AbstractJob;
use Dealroadshow\K8S\Framework\Core\Job\JobInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PriorityClass\PriorityClassConfigurator;

abstract class AbstractCronJob extends AbstractJob implements CronJobInterface
{
    public function job(): JobInterface
    {
        return $this;
    }

    public function concurrencyPolicy(): ConcurrencyPolicy
    {
        return ConcurrencyPolicy::forbid();
    }

    public function failedJobsHistoryLimit(): ?int
    {
        return null;
    }

    public function startingDeadlineSeconds(): ?int
    {
        return null;
    }

    public function successfulJobsHistoryLimit(): ?int
    {
        return null;
    }

    public function suspendCronJob(): bool
    {
        return $this->suspend();
    }

    public function priorityClass(PriorityClassConfigurator $priorityClass): void
    {
    }

    public function timeZone(): string|null
    {
        return null;
    }

    public function configureCronJob(CronJob $cronJob): void
    {
    }

    final public static function kind(): string
    {
        return CronJob::KIND;
    }

    final public static function apiVersion(): string
    {
        return CronJob::API_VERSION;
    }
}
