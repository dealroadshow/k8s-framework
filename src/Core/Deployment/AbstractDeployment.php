<?php

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\AppAwareTrait;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Containers\PodContainers;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

abstract class AbstractDeployment implements DeploymentInterface
{
    use AppAwareTrait;

    protected int $replicas = 1;

    public function affinity(AffinityConfigurator $affinity): void
    {
    }

    public function initContainers(PodContainers $containers): void
    {
    }

    public function configureMeta(MetadataConfigurator $meta): void
    {
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

    public function restartPolicy(): ?RestartPolicy
    {
        return null;
    }

    public function configurePodSpec(PodSpec $spec): void
    {
    }

    public function replicas(): int
    {
        return $this->replicas;
    }

    public function minReadySeconds(): ?int
    {
        return null;
    }

    public function progressDeadlineSeconds(): ?int
    {
        return null;
    }

    public function configureDeployment(Deployment $deployment): void
    {
    }
}
