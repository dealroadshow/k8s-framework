<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Service;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\Collection\ServicePortList;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServicePortsConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\Configurator\ServiceTypeConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\ServiceInterface;

class ServiceMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return ServiceInterface::class;
    }

    /**
     * @param ManifestInterface|ServiceInterface $manifest
     * @param AppInterface                       $app
     *
     * @return APIResourceInterface|Service
     */
    protected function makeResource(ManifestInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $service = new Service();
        $app->metadataHelper()->configureMeta($manifest, $service);

        $type = new ServiceTypeConfigurator($service);
        $manifest->type($type);

        $ports = new ServicePortsConfigurator($service->spec()->ports());
        $manifest->ports($ports);
        $this->validatePorts($service->spec()->ports(), $manifest, $app);

        $manifest->selector($service->spec()->selector());
        $manifest->configureService($service);

        return $service;
    }

    private function validatePorts(ServicePortList $ports, ServiceInterface $manifest, AppInterface $app)
    {
        $ports = $ports->all();
        if (count($ports) > 1) {
            foreach ($ports as $port) {
                if (null === $port->getName()) {
                    throw new \LogicException(
                        sprintf(
                            'Multiple ports specified for service "%s", therefore all ports must have name',
                            $app->namesHelper()->format($manifest)
                        )
                    );
                }
            }
        }
    }
}
