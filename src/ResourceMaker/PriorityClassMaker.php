<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Scheduling\PriorityClass;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\PriorityClass\PriorityClassInterface;

class PriorityClassMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return PriorityClassInterface::class;
    }

    protected function makeResource(ManifestInterface|PriorityClassInterface $manifest, AppInterface $app): PriorityClass
    {
        $priorityClass = new PriorityClass($manifest->value());
        if ($description = $manifest->description()) {
            $priorityClass->setDescription($description);
        }
        $priorityClass->setGlobalDefault($manifest->globalDefault());
        if ($preemptionPolicy = $manifest->preemptionPolicy()) {
            $priorityClass->setPreemptionPolicy($preemptionPolicy->toString());
        }

        return $priorityClass;
    }
}
