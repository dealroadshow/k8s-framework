<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\Framework\Core\ManifestProcessor;
use Dealroadshow\K8S\Framework\Dumper\Context\ContextInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;
use Dealroadshow\K8S\Framework\Registry\Query\ManifestsQuery;

class AppProcessor
{
    public function __construct(
        private AppRegistry $appRegistry,
        private ManifestRegistry $manifestRegistry,
        private ManifestProcessor $manifestProcessor,
        private ContextInterface $context,
    ) {
    }

    public function process(string $appAlias): void
    {
        $app = $this->appRegistry->get($appAlias);
        $query = $this->createQuery($appAlias);
        foreach ($query->execute() as $manifest) {
            $this->manifestProcessor->process($manifest, $app);
        }
    }

    public function processInstancesOf(string $appAlias, array $classNames): void
    {
        $app = $this->appRegistry->get($appAlias);
        $processedManifests = [];
        foreach ($classNames as $className) {
            $query = $this->createQuery($appAlias);
            $query->instancesOf($className);

            foreach ($query->execute() as $manifest) {
                if (in_array($manifest, $processedManifests)) {
                    continue;
                }
                $this->manifestProcessor->process($manifest, $app);
            }
        }
    }

    private function createQuery(string $appAlias): ManifestsQuery
    {
        $query = $this->manifestRegistry->query($appAlias);
        if ($tags = $this->context->includeTags()) {
            $query->includeTags($tags);
        }
        if ($tags = $this->context->excludeTags()) {
            $query->excludeTags($tags);
        }

        return $query;
    }
}
