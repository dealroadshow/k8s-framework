<?php

namespace Dealroadshow\K8S\Framework\Core;

interface MetadataAwareInterface
{
    public function metadata(MetadataConfigurator $meta): void;
}
