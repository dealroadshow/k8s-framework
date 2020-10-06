<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Probes;

use Dealroadshow\K8S\Data\Probe;

class ProbeConfigurator
{
    private Probe $probe;
    private ProbeActionConfigurator $action;

    public function __construct(Probe $probe)
    {
        $this->probe = $probe;
        $this->action = new ProbeActionConfigurator($probe);
    }

    public function action(): ProbeActionConfigurator
    {
        return $this->action;
    }

    public function setFailureThreshold(int $threshold): self
    {
        $this->probe->setFailureThreshold($threshold);

        return $this;
    }

    public function setInitialDelaySeconds(int $seconds): self
    {
        $this->probe->setInitialDelaySeconds($seconds);

        return $this;
    }

    public function setPeriodSeconds(int $seconds): self
    {
        $this->probe->setPeriodSeconds($seconds);

        return $this;
    }

    public function setSuccessThreshold(int $threshold): self
    {
        $this->probe->setSuccessThreshold($threshold);

        return $this;
    }

    public function setTimeoutSeconds(int $seconds): self
    {
        $this->probe->setTimeoutSeconds($seconds);

        return $this;
    }
}
