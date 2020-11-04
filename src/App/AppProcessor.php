<?php


namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\Framework\Core\AppAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestProcessor;
use Dealroadshow\K8S\Framework\Dumper\Context\ContextInterface;
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

    public function process(AppInterface $app): void
    {
        $query = $this->manifestRegistry->query();
        $query->app($app);
        if($tags = $this->context->includeTags()) {
            $query->includeTags($tags);
        }
        if($tags = $this->context->excludeTags()) {
            $query->excludeTags($tags);
        }
        foreach ($query->execute() as $manifest) {
            if($manifest instanceof AppAwareInterface) {
                $manifest->setApp($app);
            }
            $this->manifestProcessor->process($manifest, $app);
        }
    }
}