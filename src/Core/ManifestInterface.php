<?php

namespace Dealroadshow\K8S\Framework\Core;

interface ManifestInterface extends MetadataAwareInterface
{
    public static function name(): string;
    public function fileNameWithoutExtension(): string;
    public function tags(): array;
}
