<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling;

use Dealroadshow\K8S\Api\Autoscaling\V2\CrossVersionObjectReference;
use Dealroadshow\K8S\Api\Autoscaling\V2\HorizontalPodAutoscaler;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\BehaviorConfigurator;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\MetricsConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\VersionedManifestReference;

interface HorizontalPodAutoscalerInterface extends ManifestInterface
{
    public function minReplicas(): int;
    public function maxReplicas(): int;
    public function behavior(BehaviorConfigurator $behavior): void;
    public function metrics(MetricsConfigurator $metrics): void;
    public function scaleTargetRef(): VersionedManifestReference|CrossVersionObjectReference;
    public function configureHorizontalPodAutoscaler(HorizontalPodAutoscaler $hpa): void;
}
