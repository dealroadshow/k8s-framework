<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Scheduling\V1\PriorityClass;
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
        $app->metadataHelper()->configureMeta($manifest, $priorityClass);
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
