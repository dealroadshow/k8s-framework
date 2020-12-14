<?php

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\Framework\Core\ManifestProcessor;
use Dealroadshow\K8S\Framework\Dumper\Context\ContextInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class AppProcessor
{
    public function __construct(
        private AppRegistry $appRegistry,
        private ManifestRegistry $manifestRegistry,
        private ManifestProcessor $manifestProcessor,
        private ContextInterface $context
    ) {
    }

    public function processAll(string ...$appAliases): void
    {
        foreach ($appAliases as $alias) {
            $this->process($alias);
        }
    }

    public function process(string $appAlias): void
    {
        $app = $this->appRegistry->get($appAlias);
        $query = $this->manifestRegistry->query($appAlias);
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
