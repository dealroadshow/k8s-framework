<?php

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;

interface DeploymentInterface extends PodTemplateSpecInterface, ManifestInterface
{
    public function selector(SelectorConfigurator $selector): void;
    public function replicas(): int;
    public function minReadySeconds(): int|null;
    public function progressDeadlineSeconds(): int|null;
    public function configureDeployment(Deployment $deployment): void;
}
