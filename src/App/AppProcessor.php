<?php

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\Framework\Core\ManifestProcessor;
use Dealroadshow\K8S\Framework\Dumper\Context\ContextInterface;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class AppProcessor
{
    public function __construct(
        private ManifestRegistry $manifestRegistry,
        private ManifestProcessor $manifestProcessor,
        private ContextInterface $context
    ) {
    }

    public function process(AppInterface $app): void
    {
        $query = $this->manifestRegistry->query();
        $query->app($app);
        if ($tags = $this->context->includeTags()) {
            $query->includeTags($tags);
        }
        if ($tags = $this->context->excludeTags()) {
            $query->excludeTags($tags);
        }
        foreach ($query->execute() as $manifest) {
            $this->manifestProcessor->process($manifest, $app);
        }
    }
}