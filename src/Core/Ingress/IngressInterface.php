<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress;

use Dealroadshow\K8S\API\Extensions\Ingress;
use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Framework\Core\AppAwareInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendFactory;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressRulesConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface IngressInterface extends ManifestInterface, AppAwareInterface
{
    public function backend(IngressBackendFactory $factory): ?IngressBackend;
    public function rules(IngressRulesConfigurator $rules, IngressBackendFactory $factory): void;
    public function configureIngress(Ingress $ingress): void;
}
