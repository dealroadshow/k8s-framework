<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Service\Configurator;

use Dealroadshow\K8S\Api\Core\V1\Service;

class ServiceTypeConfigurator
{
    public const TYPE_CLUSTER_IP = 'ClusterIP';
    public const TYPE_NODE_PORT = 'NodePort';
    public const TYPE_LOAD_BALANCER = 'LoadBalancer';
    public const TYPE_EXTERNAL_NAME = 'ExternalName';

    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function clusterIP(): void
    {
        $this->setServiceType(self::TYPE_CLUSTER_IP);
    }

    public function nodePort(): void
    {
        $this->setServiceType(self::TYPE_NODE_PORT);
    }

    public function loadBalancer(): void
    {
        $this->setServiceType(self::TYPE_LOAD_BALANCER);
    }

    public function externalName(string $externalName): void
    {
        $this->setServiceType(self::TYPE_EXTERNAL_NAME);
        $this->service->spec()->setExternalName($externalName);
    }

    private function setServiceType(string $type): void
    {
        $existingType = $this->service->spec()->getType();
        if (null !== $existingType && $existingType !== $type) {
            throw new \LogicException(
                sprintf(
                    'Cannot set service type to "%s", it is already set to "%s"',
                    $type,
                    $existingType
                )
            );
        }
        $this->service->spec()->setType($type);
    }
}
