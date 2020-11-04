<?php


namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\Framework\Core\ManifestProcessor;
use Dealroadshow\K8S\Framework\Dumper\Context\ContextInterface;
use Dealroadshow\K8S\Framework\Project\ProjectInterface;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class AppProcessor
{
    private ManifestRegistry $manifestRegistry;
    private ManifestProcessor $manifestProcessor;
    /**
     * @var ContextInterface
     */
    private ContextInterface $context;

    public function __construct(ManifestRegistry $manifestRegistry, ManifestProcessor $manifestProcessor, ContextInterface $context)
    {
        $this->manifestRegistry = $manifestRegistry;
        $this->manifestProcessor = $manifestProcessor;
        $this->context = $context;
    }

    public function process(AppInterface $app, ProjectInterface $project): void
    {
        $app->setProject($project);
        $query = $this->manifestRegistry->query();
        $query->app($app);
        if($tags = $this->context->includeTags()) {
            $query->includeTags($tags);
        }
        if($tags = $this->context->excludeTags()) {
            $query->excludeTags($tags);
        }
        foreach ($query->execute() as $manifest) {
            $this->manifestProcessor->process($manifest, $app);
        }
    }
}