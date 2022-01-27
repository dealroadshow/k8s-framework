<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Service;

use Dealroadshow\K8S\API\Service;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServicePortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServiceTypeConfigurator;

interface ServiceInterface extends ManifestInterface
{
    public function clusterIP(): string|null;
    public function ports(ServicePortsConfigurator $ports): void;
    public function selector(StringMap $selector): void;
    public function type(ServiceTypeConfigurator $type): void;
    public function configureService(Service $service): void;
}
