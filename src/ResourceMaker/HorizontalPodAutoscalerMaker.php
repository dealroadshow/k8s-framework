<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Autoscaling\V2\CrossVersionObjectReference;
use Dealroadshow\K8S\Api\Autoscaling\V2\HorizontalPodAutoscaler;
use Dealroadshow\K8S\Api\Autoscaling\V2\HorizontalPodAutoscalerSpec;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\BehaviorConfigurator;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\MetricsConfigurator;
use Dealroadshow\K8S\Framework\Core\Autoscaling\HorizontalPodAutoscalerInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\VersionedManifestReference;
use Dealroadshow\K8S\Framework\Util\VersionedManifestReferencesService;

class HorizontalPodAutoscalerMaker extends AbstractResourceMaker
{
    public function __construct(private readonly VersionedManifestReferencesService $referencesService)
    {
    }

    protected function supportsClass(): string
    {
        return HorizontalPodAutoscalerInterface::class;
    }

    protected function makeResource(ManifestInterface|HorizontalPodAutoscalerInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $scaleTargetRef = $this->scaleTargetRef($manifest->scaleTargetRef());

        $hpaSpec = new HorizontalPodAutoscalerSpec($manifest->maxReplicas(), $scaleTargetRef);
        $hpaSpec->setMinReplicas($manifest->minReplicas());

        $metricsConfigurator = new MetricsConfigurator($hpaSpec->metrics(), $this->referencesService);
        $manifest->metrics($metricsConfigurator);

        $behaviorConfigurator = new BehaviorConfigurator($hpaSpec->behavior());
        $manifest->behavior($behaviorConfigurator);

        $hpa = new HorizontalPodAutoscaler($hpaSpec);

        $app->metadataHelper()->configureMeta($manifest, $hpa);

        $manifest->configureHorizontalPodAutoscaler($hpa);

        return $hpa;
    }

    private function scaleTargetRef(VersionedManifestReference|CrossVersionObjectReference $reference): CrossVersionObjectReference
    {
        if ($reference instanceof CrossVersionObjectReference) {
            return $reference;
        }

        return $this->referencesService->toCrossVersionObjectReference($reference);
    }
}
