<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\K8S\Framework\Core\DynamicNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\FullNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

final readonly class ManifestShortName
{
    public static function getFrom(ManifestInterface $manifest): string
    {
        if ($manifest instanceof FullNameAwareInterface) {
            throw new \LogicException(sprintf('Instances of class "%s" are full name aware (see "%s"), therefore manifest short name cannot be derived', ClassName::real($manifest), FullNameAwareInterface::class));
        }

        return $manifest instanceof DynamicNameAwareInterface
            ? $manifest->name()
            : $manifest::shortName();
    }
}
