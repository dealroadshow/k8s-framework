<?php

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Framework\Core\AppAwareInterface;
use Dealroadshow\K8S\Framework\Core\LabelSelector\LabelSelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;

interface DeploymentInterface extends PodTemplateSpecInterface, ManifestInterface, AppAwareInterface
{
    public function labelSelector(LabelSelectorConfigurator $selector): void;
    public function replicas(): ?int;
    public function minReadySeconds(): ?int;
    public function progressDeadlineSeconds(): ?int;
    public function configureDeployment(Deployment $deployment): void;
}
