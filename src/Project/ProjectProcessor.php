<?php

namespace Dealroadshow\K8S\Framework\Project;

use Dealroadshow\K8S\Framework\App\AppProcessor;

class ProjectProcessor
{
    private AppProcessor $appProcessor;

    public function __construct(AppProcessor $appProcessor)
    {
        $this->appProcessor = $appProcessor;
    }

    public function process(ProjectInterface $project, string $tag = null): void
    {
        foreach ($project->apps() as $app) {
            $this->appProcessor->process($app, $tag);
        }
    }
}
