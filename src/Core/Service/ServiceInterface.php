<?php

namespace Dealroadshow\K8S\Framework\Core\Service;

use Dealroadshow\K8S\API\Service;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AppAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServicePortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServiceTypeConfigurator;

interface ServiceInterface extends ManifestInterface, AppAwareInterface
{
    public function ports(ServicePortsConfigurator $ports): void;
    public function selector(StringMap $selector): void;
    public function type(ServiceTypeConfigurator $type): void;
    public function configureService(Service $service): void;
}
