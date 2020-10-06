<?php

namespace Dealroadshow\K8S\Framework\Project;

use Dealroadshow\K8S\Framework\App\AppInterface;

interface ProjectInterface
{
    /**
     * @return AppInterface[]|iterable
     */
    public function apps(): iterable;
    public function name(): string;
}
