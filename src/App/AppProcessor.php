<?php


namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\Framework\Core\ManifestProcessor;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class AppProcessor
{
    private ManifestRegistry $manifestRegistry;
    private ManifestProcessor $manifestProcessor;

    public function __construct(ManifestRegistry $manifestRegistry, ManifestProcessor $manifestProcessor)
    {
        $this->manifestRegistry = $manifestRegistry;
        $this->manifestProcessor = $manifestProcessor;
    }

    public function process(AppInterface $app): void
    {
        $query = $this->manifestRegistry->query();
        $query->app($app);
        foreach ($query->execute() as $manifest) {
            $this->manifestProcessor->process($manifest, $app);
        }
    }
}