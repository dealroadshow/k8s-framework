<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Batch\Job;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\CronJob\CronJobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobSpecProcessor;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;

class JobMaker extends AbstractResourceMaker
{
    private JobSpecProcessor $jobSpecProcessor;

    public function __construct(JobSpecProcessor $jobSpecProcessor)
    {
        $this->jobSpecProcessor = $jobSpecProcessor;
    }

    public function supports(ManifestInterface $manifest, AppInterface $app): bool
    {
        return $manifest instanceof JobInterface && !($manifest instanceof CronJobInterface);
    }

    protected function makeResource(ManifestInterface|JobInterface $manifest, AppInterface $app): Job
    {
        $job = new Job();
        $spec = $job->spec();

        $manifest->selector(new SelectorConfigurator($spec->selector()));

        $app->metadataHelper()->configureMeta($manifest, $job);
        $this->jobSpecProcessor->process($manifest, $spec, $app);
        foreach ($spec->selector()->matchLabels()->all() as $name => $value) {
            $job->metadata()->labels()->add($name, $value);
        }

        $manifest->configureJob($job);

        if (null === $job->spec()->template()->spec()->getRestartPolicy()) {
            $job->spec()->template()->spec()->setRestartPolicy(
                RestartPolicy::never()->toString()
            );
        }

        return $job;
    }

    protected function supportsClass(): string
    {
        return JobInterface::class;
    }
}
