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

    public function process(ProjectInterface $project): void
    {
        foreach ($project->apps() as $app) {
            $app->setProject($project);
            $this->appProcessor->process($app);
        }
    }
}
