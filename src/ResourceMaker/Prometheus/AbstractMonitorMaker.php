<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker\Prometheus;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\Collection\StringList;
use Dealroadshow\K8S\Data\LabelSelector;
use Dealroadshow\K8S\Data\ObjectMeta;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\EndpointsConfigurator;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\NamespaceSelectorConfigurator;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\MonitorApiResource;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\MonitorInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\AbstractResourceMaker;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\ConfigureSelectorTrait;

abstract class AbstractMonitorMaker extends AbstractResourceMaker
{
    use ConfigureSelectorTrait;

    abstract protected function configureMonitor(MonitorInterface $manifest, \ArrayObject $data): void;

    protected function makeResource(ManifestInterface|MonitorInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $data = new \ArrayObject();
        $data['apiVersion'] = $manifest->apiVersion();
        $data['kind'] = $manifest::kind();
        $data['metadata'] = new ObjectMeta();
        $data['spec'] = new \ArrayObject();
        $data['spec']['selector'] = new LabelSelector();
        $data['spec']['namespaceSelector'] = new \ArrayObject();

        $monitor = new MonitorApiResource($data);
        $app->metadataHelper()->configureMeta($manifest, $monitor);
        $this->configureSelector($manifest, $data['spec']['selector']);

        $namespaceSelector = new NamespaceSelectorConfigurator($data['spec']['namespaceSelector']);
        $manifest->namespaceSelector($namespaceSelector);

        $podTargetLabels = new StringList();
        $manifest->podTargetLabels($podTargetLabels);

        if ($podTargetLabels->count() > 0) {
            $data['spec']['podTargetLabels'] = $podTargetLabels;
        }

        if ($jobLabel = $manifest->jobLabel()) {
            $data['spec']['jobLabel'] = $jobLabel;
        }

        if ($sampleLimit = $manifest->sampleLimit()) {
            $data['spec']['sampleLimit'] = $sampleLimit;
        }

        return $monitor;
    }


}
