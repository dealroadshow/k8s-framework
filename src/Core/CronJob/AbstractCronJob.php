<?php

namespace Dealroadshow\K8S\Framework\Core\CronJob;

use Dealroadshow\K8S\API\Batch\CronJob;
use Dealroadshow\K8S\Framework\Core\ConfigureTagsTrait;

abstract class AbstractCronJob implements CronJobInterface
{
    use ConfigureTagsTrait;

    public function concurrencyPolicy(): ?string
    {
        return null;
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

    public function configureCronJob(CronJob  $cronJob): void
    {
    }
}
