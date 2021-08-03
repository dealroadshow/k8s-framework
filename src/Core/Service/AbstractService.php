<?php

namespace Dealroadshow\K8S\Framework\Core\Service;

use Dealroadshow\K8S\API\Service;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServicePortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServiceTypeConfigurator;

abstract class AbstractService extends AbstractManifest implements ServiceInterface
{
    public function clusterIP(): string|null
    {
        return null;
    }

    public function ports(ServicePortsConfigurator $ports): void
    {
    }

    public function selector(StringMap $selector): void
    {
    }

    public function type(ServiceTypeConfigurator $type): void
    {
    }

    public function configureService(Service $service): void
    {
    }

    final public static function kind(): string
    {
        return Service::KIND;
    }
}
