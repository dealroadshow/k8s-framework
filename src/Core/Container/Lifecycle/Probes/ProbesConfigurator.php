<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes;

use Dealroadshow\K8S\Data\Probe;

class ProbesConfigurator
{
    private Probe $livenessProbe;
    private Probe $readinessProbe;
    private Probe $startupProbe;

    public function __construct(Probe $livenessProbe, Probe $readinessProbe, Probe $startupProbe)
    {
        $this->livenessProbe = $livenessProbe;
        $this->readinessProbe = $readinessProbe;
        $this->startupProbe = $startupProbe;
    }

    public function livenessProbe(): ProbeConfigurator
    {
        return new ProbeConfigurator($this->livenessProbe);
    }

    public function readinessProbe(): ProbeConfigurator
    {
        return new ProbeConfigurator($this->readinessProbe);
    }

    public function startupProbe(): ProbeConfigurator
    {
        return new ProbeConfigurator($this->startupProbe);
    }
}
