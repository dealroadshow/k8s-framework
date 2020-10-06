<?php

namespace Dealroadshow\K8S\Framework\Core\Pod;

use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\Core\Pod\Affinity\AffinityConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Containers\PodContainers;
use Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets\ImagePullSecretsConfigurator;
use Dealroadshow\K8S\Framework\Core\Pod\Policy\RestartPolicy;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\VolumesConfigurator;

interface PodSpecInterface
{
    public function affinity(AffinityConfigurator $affinity): void;
    public function containers(PodContainers $containers): void;
    public function initContainers(PodContainers $containers): void;
    public function imagePullSecrets(ImagePullSecretsConfigurator $secrets): void;
    public function nodeSelector(StringMap $nodeSelector): void;
    public function volumes(VolumesConfigurator $volumes): void;
    public function restartPolicy(): ?RestartPolicy;
    public function configurePodSpec(PodSpec $spec): void;
}
