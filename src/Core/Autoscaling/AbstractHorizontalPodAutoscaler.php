<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling;

use Dealroadshow\K8S\API\Autoscaling\HorizontalPodAutoscaler;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\BehaviorConfigurator;

abstract class AbstractHorizontalPodAutoscaler extends AbstractManifest implements HorizontalPodAutoscalerInterface
{
    public function minReplicas(): int
    {
        return 1;
    }

    public function behavior(BehaviorConfigurator $behavior): void
    {
    }

    public function configureHorizontalPodAutoscaler(HorizontalPodAutoscaler $hpa): void
    {
    }

    public static function apiVersion(): string
    {
        return HorizontalPodAutoscaler::API_VERSION;
    }

    public static function kind(): string
    {
        return HorizontalPodAutoscaler::KIND;
    }
}
