<?php

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Containers\PodContainers;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

abstract class AbstractDeployment extends AbstractManifest implements DeploymentInterface
{
    public function affinity(AffinityConfigurator $affinity): void
    {
    }

    public function initContainers(PodContainers $containers): void
    {
    }

    public function imagePullSecrets(ImagePullSecretsConfigurator $secrets): void
    {
    }

    public static function kind(): string
    {
        return Deployment::KIND;
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
        return 1;
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
