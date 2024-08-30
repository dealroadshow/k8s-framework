<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator;

use Dealroadshow\K8S\Api\Autoscaling\V2\ContainerResourceMetricSource;
use Dealroadshow\K8S\Api\Autoscaling\V2\CrossVersionObjectReference;
use Dealroadshow\K8S\Api\Autoscaling\V2\ExternalMetricSource;
use Dealroadshow\K8S\Api\Autoscaling\V2\MetricIdentifier;
use Dealroadshow\K8S\Api\Autoscaling\V2\MetricSpec;
use Dealroadshow\K8S\Api\Autoscaling\V2\MetricSpecList;
use Dealroadshow\K8S\Api\Autoscaling\V2\MetricTarget;
use Dealroadshow\K8S\Api\Autoscaling\V2\ObjectMetricSource;
use Dealroadshow\K8S\Api\Autoscaling\V2\PodsMetricSource;
use Dealroadshow\K8S\Api\Autoscaling\V2\ResourceMetricSource;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Metric\SourceType;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Metric\TypedMetricTarget;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Metric\TargetType;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResource;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\VersionedManifestReference;
use Dealroadshow\K8S\Framework\Util\VersionedManifestReferencesService;

final readonly class MetricsConfigurator
{
    public function __construct(private MetricSpecList $metrics, private VersionedManifestReferencesService $referencesService)
    {
    }

    public function addResourceMetric(ContainerResource $resource, TypedMetricTarget $target): self
    {
        $target = $this->dtoToMetricTarget($target);
        $source = new ResourceMetricSource($resource->value, $target);
        $spec = new MetricSpec(SourceType::Resource->value);
        $spec->setResource($source);
        $this->metrics->add($spec);

        return $this;
    }

    public function addContainerResourceMetric(ContainerResource $resource, TypedMetricTarget $target, string $container): self
    {
        $target = $this->dtoToMetricTarget($target);
        $source = new ContainerResourceMetricSource($container, $resource->value, $target);
        $spec = new MetricSpec(SourceType::ContainerResource->value);
        $spec->setContainerResource($source);
        $this->metrics->add($spec);

        return $this;
    }

    public function addExternalMetric(string $name, TypedMetricTarget $target, \Closure $selectorCallback = null): self
    {
        $target = $this->dtoToMetricTarget($target);
        $identifier = $this->createMetricIdentifier($name, $selectorCallback);

        $source = new ExternalMetricSource($identifier, $target);
        $spec = new MetricSpec(SourceType::External->value);
        $spec->setExternal($source);
        $this->metrics->add($spec);

        return $this;
    }

    public function addObjectMetric(string $name, TypedMetricTarget $target, VersionedManifestReference|CrossVersionObjectReference $describedObject, \Closure $selectorCallback = null): self
    {
        $target = $this->dtoToMetricTarget($target);
        $identifier = $this->createMetricIdentifier($name, $selectorCallback);
        if ($describedObject instanceof VersionedManifestReference) {
            $describedObject = $this->referencesService->toCrossVersionObjectReference($describedObject);
        }

        $source = new ObjectMetricSource(describedObject: $describedObject, metric: $identifier, target: $target);
        $spec = new MetricSpec(SourceType::Object->value);
        $spec->setObject($source);
        $this->metrics->add($spec);

        return $this;
    }

    public function addPodsMetric(string $name, TypedMetricTarget $target, \Closure $selectorCallback = null): self
    {
        $target = $this->dtoToMetricTarget($target);
        $identifier = $this->createMetricIdentifier($name, $selectorCallback);

        $source = new PodsMetricSource($identifier, $target);
        $spec = new MetricSpec(SourceType::Pods->value);
        $spec->setPods($source);
        $this->metrics->add($spec);

        return $this;
    }

    private function createMetricIdentifier(string $name, \Closure|null $selectorCallback): MetricIdentifier
    {
        $identifier = new MetricIdentifier($name);
        if ($selectorCallback) {
            $selectorConfigurator = new SelectorConfigurator($identifier->selector());
            $selectorCallback($selectorConfigurator);
        }

        return $identifier;
    }

    private function dtoToMetricTarget(TypedMetricTarget $dto): MetricTarget
    {
        $target = new MetricTarget($dto->type->value);
        $methodName = match ($dto->type) {
            TargetType::Utilization => 'setAverageUtilization',
            TargetType::AverageValue => 'setAverageValue',
            TargetType::Value => 'setValue',
        };

        call_user_func([$target, $methodName], $dto->value);

        return $target;
    }
}
