<?php

namespace Dealroadshow\K8S\Framework\Core;

interface MetadataAwareInterface
{
    public function configureMeta(MetadataConfigurator $meta): void;
}
