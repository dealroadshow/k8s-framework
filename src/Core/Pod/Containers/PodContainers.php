<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Containers;

use Dealroadshow\K8S\Framework\Core\Container\ContainerInterface;

class PodContainers
{
    private \ArrayObject $containers;

    public function __construct(\ArrayObject $containers)
    {
        $this->containers = $containers;
    }

    public function add(ContainerInterface $container): self
    {
        $this->containers->append($container);

        return $this;
    }

    /**
     * @param array|ContainerInterface[] $containers
     *
     * @return $this
     */
    public function addAll(array $containers): self
    {
        // loop is used in order to validate that all containers are ContainerInterface instances
        foreach ($containers as $container) {
            $this->add($container);
        }

        return $this;
    }
}