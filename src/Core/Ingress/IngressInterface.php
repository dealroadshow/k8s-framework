<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress;

use Dealroadshow\K8S\Api\Networking\V1\Ingress;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendConfigurator;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressRulesConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface IngressInterface extends ManifestInterface
{
    public function defaultBackend(IngressBackendConfigurator $factory): void;
    public function ingressClassName(): string|null;
    public function rules(IngressRulesConfigurator $rules): void;
    public function configureIngress(Ingress $ingress): void;
}
