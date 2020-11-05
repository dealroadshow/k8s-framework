<?php

namespace Dealroadshow\K8S\Framework\Core;

interface ManifestInterface extends MetadataAwareInterface
{
    public static function shortName(): string;
    public function fileNameWithoutExtension(): string;
}
