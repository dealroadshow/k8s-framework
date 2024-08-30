<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\K8S\Framework\Core\DynamicNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

final readonly class ManifestShortName
{
    public static function getFrom(ManifestInterface $manifest): string
    {
        return $manifest instanceof DynamicNameAwareInterface
            ? $manifest->name()
            : $manifest::shortName();
    }
}
