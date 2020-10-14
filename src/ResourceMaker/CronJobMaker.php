<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Batch\CronJob;
use Dealroadshow\K8S\Data\CronJobSpec;
use Dealroadshow\K8S\Data\JobTemplateSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\CronJob\CronJobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobSpecProcessor;
use Dealroadshow\K8S\Framework\Core\LabelSelector\LabelSelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class CronJobMaker extends AbstractResourceMaker
{
    private JobSpecProcessor $jobSpecProcessor;

    public function __construct(JobSpecProcessor $jobSpecProcessor)
    {
        $this->jobSpecProcessor = $jobSpecProcessor;
    }

    /**
     * @param ManifestInterface|CronJobInterface $manifest
     * @param AppInterface                       $app
     *
     * @return CronJob
     */
    protected function makeResource(ManifestInterface $manifest, AppInterface $app): CronJob
    {
        $spec = new CronJobSpec($manifest->schedule());
        $cronJob = new CronJob($spec);

        $app->metadataHelper()->configureMeta($manifest, $cronJob);

        $this->configureJobTemplate($spec->jobTemplate(), $manifest->job(), $app);

        $concurrencyPolicy = $manifest->concurrencyPolicy();
        $failedJobsHistoryLimit = $manifest->failedJobsHistoryLimit();
        $startingDeadlineSeconds = $manifest->startingDeadlineSeconds();
        $successfulJobsHistoryLimit = $manifest->successfulJobsHistoryLimit();
        $suspend = $manifest->suspend();
        if (null !== $concurrencyPolicy) {
            $spec->setConcurrencyPolicy($concurrencyPolicy);
        }
        if (null !== $failedJobsHistoryLimit) {
            $spec->setFailedJobsHistoryLimit($failedJobsHistoryLimit);
        }
        if (null !== $startingDeadlineSeconds) {
            $spec->setStartingDeadlineSeconds($startingDeadlineSeconds);
        }
        if (null !== $successfulJobsHistoryLimit) {
            $spec->setSuccessfulJobsHistoryLimit($successfulJobsHistoryLimit);
        }
        if (null !== $suspend) {
            $spec->setSuspend($suspend);
        }
        $manifest->configureCronJob($cronJob);

        return $cronJob;
    }

    private function configureJobTemplate(JobTemplateSpec $templateSpec, JobInterface $manifest, AppInterface $app)
    {
        $jobSpec = $templateSpec->spec();
        $manifest->labelSelector(new LabelSelectorConfigurator($jobSpec->selector()));
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
