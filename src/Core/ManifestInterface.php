<?php

namespace Dealroadshow\K8S\Framework\Core;

interface ManifestInterface extends MetadataAwareInterface
{
    public function name(): string;
    public function fileNameWithoutExtension(): string;
}
