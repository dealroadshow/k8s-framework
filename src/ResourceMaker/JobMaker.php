<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Batch\Job;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobInterface;
use Dealroadshow\K8S\Framework\Core\Job\JobSpecProcessor;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class JobMaker extends AbstractResourceMaker
{
    private JobSpecProcessor $jobSpecProcessor;

    public function __construct(JobSpecProcessor $jobSpecProcessor)
    {
        $this->jobSpecProcessor = $jobSpecProcessor;
    }

    protected function makeResource(ManifestInterface|JobInterface $manifest, AppInterface $app): Job
    {
        $job = new Job();
        $spec = $job->spec();

        $manifest->labelSelector(new SelectorConfigurator($spec->selector()));

        $app->metadataHelper()->configureMeta($manifest, $job);
        $this->jobSpecProcessor->process($manifest, $spec, $app);
        foreach ($spec->selector()->matchLabels()->all() as $name => $value) {
            $job->metadata()->labels()->add($name, $value);
        }

        $manifest->configureJob($job);

        return $job;
    }

    protected function supportsClass(): string
    {
        return JobInterface::class;
    }
}
