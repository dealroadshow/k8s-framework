<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Batch\V1\CronJob;
use Dealroadshow\K8S\Api\Batch\V1\CronJobSpec;
use Dealroadshow\K8S\Api\Batch\V1\JobTemplateSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\CronJob\CronJobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobSpecProcessor;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Event\CronJobGeneratedEvent;

class CronJobMaker extends AbstractResourceMaker
{
    private readonly JobSpecProcessor $jobSpecProcessor;

    public function __construct(JobSpecProcessor $jobSpecProcessor)
    {
        $this->jobSpecProcessor = $jobSpecProcessor;
    }

    protected function makeResource(ManifestInterface|CronJobInterface $manifest, AppInterface $app): CronJob
    {
        $spec = new CronJobSpec($manifest->schedule());
        $cronJob = new CronJob($spec);

        $app->metadataHelper()->configureMeta($manifest, $cronJob);

        $this->configureJobTemplate($spec->jobTemplate(), $manifest->job(), $app);

        $concurrencyPolicy = $manifest->concurrencyPolicy();
        $failedJobsHistoryLimit = $manifest->failedJobsHistoryLimit();
        $startingDeadlineSeconds = $manifest->startingDeadlineSeconds();
        $successfulJobsHistoryLimit = $manifest->successfulJobsHistoryLimit();
        $spec->setSuspend($manifest->suspendCronJob());
        $spec->setConcurrencyPolicy($concurrencyPolicy->toString());
        if (null !== $failedJobsHistoryLimit) {
            $spec->setFailedJobsHistoryLimit($failedJobsHistoryLimit);
        }
        if (null !== $startingDeadlineSeconds) {
            $spec->setStartingDeadlineSeconds($startingDeadlineSeconds);
        }
        if (null !== $successfulJobsHistoryLimit) {
            $spec->setSuccessfulJobsHistoryLimit($successfulJobsHistoryLimit);
        }

        $timeZone = $manifest->timeZone();
        if (null !== $timeZone) {
            try {
                new \DateTimeZone($timeZone);
                $spec->setTimeZone($timeZone);
            } catch (\Exception) {
                throw new \InvalidArgumentException(
                    sprintf('Invalid timezone "%s" in cron job "%s".', $timeZone, $cronJob->metadata()->getName())
                );
            }
        }

        $manifest->configureCronJob($cronJob);

        if (null === $cronJob->getSpec()->jobTemplate()->spec()->template()->spec()->getRestartPolicy()) {
            $cronJob->getSpec()->jobTemplate()->spec()->template()->spec()->setRestartPolicy(
                RestartPolicy::never()->toString()
            );
        }

        $this->dispatcher->dispatch(new CronJobGeneratedEvent($manifest, $cronJob, $app), CronJobGeneratedEvent::NAME);

        return $cronJob;
    }

    private function configureJobTemplate(JobTemplateSpec $templateSpec, JobInterface $manifest, AppInterface $app): void
    {
        $jobSpec = $templateSpec->spec();
        $manifest->selector(new SelectorConfigurator($jobSpec->selector()));
        $this->jobSpecProcessor->process($manifest, $jobSpec, $app);
        foreach ($jobSpec->selector()->matchLabels()->all() as $name => $value) {
            $templateSpec->metadata()->labels()->add($name, $value);
        }
    }

    protected function supportsClass(): string
    {
        return CronJobInterface::class;
    }
}
