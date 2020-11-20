<?php

namespace Dealroadshow\K8S\Framework\Core\Pod;

use Dealroadshow\K8S\Data\PodTemplateSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;

class PodTemplateSpecProcessor
{
    private PodSpecProcessor $specProcessor;

    public function __construct(PodSpecProcessor $specProcessor)
    {
        $this->specProcessor = $specProcessor;
    }

    public function process(PodTemplateSpecInterface $builder, PodTemplateSpec $templateSpec, AppInterface $app): void
    {
        $meta = $templateSpec->metadata();
        $metaConfigurator = new MetadataConfigurator($meta->labels(), $meta->annotations());
        $builder->metadata($metaConfigurator);

        $this->specProcessor->process($builder, $templateSpec->spec(), $app);
    }
}
