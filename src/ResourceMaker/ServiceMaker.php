<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Core\V1\Service;
use Dealroadshow\K8S\Api\Core\V1\ServicePortList;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServicePortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServiceTypeConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\ServiceInterface;
use Dealroadshow\K8S\Framework\Event\ServiceGeneratedEvent;

class ServiceMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return ServiceInterface::class;
    }

    protected function makeResource(ManifestInterface|ServiceInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $service = new Service();
        $app->metadataHelper()->configureMeta($manifest, $service);

        $clusterIp = $manifest->clusterIP();
        if (null !== $clusterIp) {
            $service->spec()->setClusterIP($clusterIp);
        }

        $trafficDistribution = $manifest->trafficDistribution();
        if (null !== $trafficDistribution) {
            $service->spec()->setTrafficDistribution($trafficDistribution);
        }
        $type = new ServiceTypeConfigurator($service);
        $manifest->type($type);

        $ports = new ServicePortsConfigurator($service->spec()->ports());
        $manifest->ports($ports);
        $this->validatePorts($service->spec()->ports(), $manifest, $app);

        $manifest->selector($service->spec()->selector());
        $manifest->configureService($service);

        $this->dispatcher->dispatch(new ServiceGeneratedEvent($manifest, $service, $app), ServiceGeneratedEvent::NAME);

        return $service;
    }

    private function validatePorts(ServicePortList $ports, ServiceInterface $manifest, AppInterface $app): void
    {
        $ports = $ports->all();
        if (count($ports) > 1) {
            foreach ($ports as $port) {
                if (null === $port->getName()) {
                    throw new \LogicException(
                        sprintf(
                            'Multiple ports specified for service "%s", therefore all ports must have name',
                            $app->namesHelper()->fullName($manifest::shortName())
                        )
                    );
                }
            }
        }
    }
}
