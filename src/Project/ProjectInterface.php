<?php

namespace Dealroadshow\K8S\Framework\Project;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Config\ConfigurableInterface;

interface ProjectInterface extends ConfigurableInterface
{
    /**
     * @return AppInterface[]|iterable
     */
    public function apps(): iterable;
    public function name(): string;
}
