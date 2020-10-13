<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Batch\Job;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecProcessor;

class JobMaker extends AbstractResourceMaker
{
    private PodTemplateSpecProcessor $specProcessor;

    public function __construct(PodTemplateSpecProcessor $specProcessor)
    {
        $this->specProcessor = $specProcessor;
    }

    /**
     * @param ManifestInterface|JobInterface $manifest
     * @param AppInterface                   $app
     *
     * @return Job
     */
    protected function makeResource(ManifestInterface $manifest, AppInterface $app): Job
    {
        $job = new Job();

        $app->metadataHelper()->configureMeta($manifest, $job);
        $this->specProcessor->process($manifest, $job->spec()->template(), $app);

        $spec = $job->spec();
        foreach ($spec->selector()->matchLabels()->all() as $name => $value) {
            $job->metadata()->labels()->add($name, $value);
            $job->spec()->template()->metadata()->labels()->add($name, $value);
        }

        $backoffLimit = $manifest->backoffLimit();
        $activeDeadlineSeconds = $manifest->activeDeadlineSeconds();
        $ttlSecondsAfterFinished = $manifest->ttlSecondsAfterFinished();
        $completions = $manifest->completions();
        $manualSelector = $manifest->manualSelector();
        $parallelism = $manifest->parallelism();
        if (null !== $backoffLimit) {
            $spec->setBackoffLimit($backoffLimit);
        }
        if (null !== $activeDeadlineSeconds) {
            $spec->setActiveDeadlineSeconds($activeDeadlineSeconds);
        }
        if (null !== $ttlSecondsAfterFinished) {
            $spec->setTtlSecondsAfterFinished($ttlSecondsAfterFinished);
        }
        if (null !== $completions) {
            $spec->setCompletions($completions);
        }
        if (null !== $manualSelector) {
            $spec->setManualSelector($manualSelector);
        }
        if (null !== $parallelism) {
            $spec->setParallelism($parallelism);
        }
        $manifest->configureJob($job);

        return $job;
    }

    protected function supportsClass(): string
    {
        return JobInterface::class;
    }
}