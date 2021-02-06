<?php

namespace Dealroadshow\K8S\Framework\Core\CronJob;

use Dealroadshow\K8S\API\Batch\CronJob;
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
        return ConcurrencyPolicy::allow();
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

    public function suspend(): ?bool
    {
        return null;
    }

    public function priorityClass(PriorityClassConfigurator $priorityClass): void
    {
    }

    public function configureCronJob(CronJob  $cronJob): void
    {
    }

    final public static function kind(): string
    {
        return CronJob::KIND;
    }
}
