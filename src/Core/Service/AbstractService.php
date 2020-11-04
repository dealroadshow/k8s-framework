<?php

namespace Dealroadshow\K8S\Framework\Core\Service;

use Dealroadshow\K8S\API\Service;
use Dealroadshow\K8S\Data\Collection\StringMap;
use Dealroadshow\K8S\Framework\Core\AppAwareTrait;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServicePortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServiceTypeConfigurator;

abstract class AbstractService implements ServiceInterface
{
    use AppAwareTrait;

    public function configureMeta(MetadataConfigurator $meta): void
    {
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
}
