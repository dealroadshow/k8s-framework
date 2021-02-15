<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\Data\Collection\StringList;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\NamespaceSelectorConfigurator;

interface MonitorInterface extends ManifestInterface
{
    public function apiVersion(): string;
    public function jobLabel(): string|null;
    public function namespaceSelector(NamespaceSelectorConfigurator $namespaceSelector): void;
    public function podTargetLabels(StringList $labels): void;
    public function sampleLimit(): int|null;
    public function selector(SelectorConfigurator $selector): void;
}
