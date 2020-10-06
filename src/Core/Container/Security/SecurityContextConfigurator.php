<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Security;

use Dealroadshow\K8S\Data\SecurityContext;

class SecurityContextConfigurator
{
    private SecurityContext $context;

    public function __construct(SecurityContext $context)
    {
        $this->context = $context;
    }

    public function capabilities(): CapabilitiesConfigurator
    {
        return new CapabilitiesConfigurator($this->context->capabilities());
    }

    public function seLinuxOptions(): SELinuxOptionsConfigurator
    {
        return new SELinuxOptionsConfigurator($this->context->seLinuxOptions());
    }

    public function allowPrivilegeEscalation(bool $allow): self
    {
        $this->context->setAllowPrivilegeEscalation($allow);

        return $this;
    }

    public function setPrivileged(bool $privileged): self
    {
        $this->context->setPrivileged($privileged);

        return $this;
    }

    public function setProcMount(string $procMount): self
    {
        $this->context->setProcMount($procMount);

        return $this;
    }

    public function setReadOnlyRootFilesystem(bool $readOnlyRootFilesystem): self
    {
        $this->context->setReadOnlyRootFilesystem($readOnlyRootFilesystem);

        return $this;
    }

    public function setRunAsGroup(int $group): self
    {
        $this->context->setRunAsGroup($group);

        return $this;
    }

    public function runAsNonRoot(bool $runAsNonRoot): self
    {
        $this->context->setRunAsNonRoot($runAsNonRoot);

        return $this;
    }

    public function runAsUser(int $user): self
    {
        $this->context->setRunAsUser($user);

        return $this;
    }
}
