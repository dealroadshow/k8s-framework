<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker\Traits;

use Dealroadshow\K8S\Data\LabelSelector;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

trait ConfigureSelectorTrait
{
    private function configureSelector(ManifestInterface $manifest, LabelSelector $specSelector)
    {
        $selector = new SelectorConfigurator($specSelector);
        $manifest->selector($selector);

        if (0 === $specSelector->matchLabels()->count() && 0 === $specSelector->matchExpressions()->count()) {
            throw new \LogicException(
                sprintf(
                    'Manifest class "%s" does not provide selector labels or expressions. Please implement method "%s"::selector()',
                    $manifest::class,
                    $manifest::class,
                )
            );
        }
    }
}
