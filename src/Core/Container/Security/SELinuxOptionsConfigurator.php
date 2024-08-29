<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Security;

use Dealroadshow\K8S\Api\Core\V1\SELinuxOptions;

class SELinuxOptionsConfigurator
{
    /**
     * @var SELinuxOptions
     */
    private SELinuxOptions $options;


    public function __construct(SELinuxOptions $options)
    {
        $this->options = $options;
    }

    /**
     * Level is SELinux level label that applies to the container.
     *
     * @param string $level
     *
     * @return $this
     */
    public function setLevel(string $level): self
    {
        $this->options->setLevel($level);

        return $this;
    }

    /**
     * Role is a SELinux role label that applies to the container.
     *
     * @param string $role
     *
     * @return $this
     */
    public function setRole(string $role): self
    {
        $this->options->setRole($role);

        return $this;
    }

    /**
     * Type is a SELinux type label that applies to the container.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->options->setType($type);

        return $this;
    }

    /**
     * User is a SELinux user label that applies to the container.
     *
     * @param string $user
     *
     * @return $this
     */
    public function setUser(string $user): self
    {
        $this->options->setUser($user);

        return $this;
    }
}
