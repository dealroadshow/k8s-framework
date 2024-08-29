<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Job;

use Dealroadshow\K8S\Api\Batch\V1\JobSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecProcessor;

class JobSpecProcessor
{
    private PodTemplateSpecProcessor $podSpecProcessor;

    public function __construct(PodTemplateSpecProcessor $podSpecProcessor)
    {
        $this->podSpecProcessor = $podSpecProcessor;
    }

    public function process(JobInterface $manifest, JobSpec $spec, AppInterface $app): void
    {
        $this->podSpecProcessor->process($manifest, $spec->template(), $app);

        foreach ($spec->selector()->matchLabels()->all() as $name => $value) {
            $spec->template()->metadata()->labels()->add($name, $value);
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

        $spec->setSuspend($manifest->suspend());
    }
}
