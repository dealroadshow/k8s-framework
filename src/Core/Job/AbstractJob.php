<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Job;

use Dealroadshow\K8S\API\Batch\Job;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\PriorityClass\PriorityClassConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

abstract class AbstractJob extends AbstractManifest implements JobInterface
{
    public function selector(SelectorConfigurator $selector): void
    {
    }

    public function backoffLimit(): ?int
    {
        return null;
    }

    public function activeDeadlineSeconds(): ?int
    {
        return null;
    }

    public function ttlSecondsAfterFinished(): ?int
    {
        return null;
    }

    public function completions(): ?int
    {
        return null;
    }

    public function manualSelector(): ?bool
    {
        return null;
    }

    public function parallelism(): ?int
    {
        return null;
    }

    public function affinity(AffinityConfigurator $affinity): void
    {
    }

    public function initContainers(): iterable
    {
        return [];
    }

    public function imagePullSecrets(ImagePullSecretsConfigurator $secrets): void
    {
    }

    public function nodeSelector(StringMap $nodeSelector): void
    {
    }

    public function volumes(VolumesConfigurator $volumes): void
    {
    }

    public function priorityClass(PriorityClassConfigurator $priorityClass): void
    {
    }

    public function restartPolicy(): RestartPolicy|null
    {
        return null;
    }

    public function configurePodSpec(PodSpec $spec): void
    {
    }

    public function configureJob(Job $job): void
    {
    }

    public static function kind(): string
    {
        return Job::KIND;
    }
}
