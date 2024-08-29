<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker\Traits;

use Dealroadshow\K8S\Apimachinery\Pkg\Apis\Meta\V1\LabelSelector;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Util\ClassName;

trait ConfigureSelectorTrait
{
    private function configureSelector(ManifestInterface $manifest, LabelSelector $specSelector): void
    {
        $selector = new SelectorConfigurator($specSelector);
        $manifest->selector($selector);

        if (0 === $specSelector->matchLabels()->count() && 0 === $specSelector->matchExpressions()->count()) {
            throw new \LogicException(
                sprintf(
                    'Manifest class "%s" does not provide selector labels or expressions. Please implement method "%s"::selector()',
                    ClassName::real($manifest),
                    ClassName::real($manifest),
                )
            );
        }
    }
}
