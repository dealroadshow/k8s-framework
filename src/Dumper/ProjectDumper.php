<?php

namespace Dealroadshow\K8S\Framework\Dumper;

use Dealroadshow\K8S\Framework\Project\ProjectInterface;

class ProjectDumper
{
    private AppDumper $appDumper;

    public function __construct(AppDumper $appDumper)
    {
        $this->appDumper = $appDumper;
    }

    public function dump(ProjectInterface $project, string $projectDir)
    {
        @mkdir($projectDir, 0777, true);
        foreach ($project->apps() as $app) {
            $appDir = $projectDir.DIRECTORY_SEPARATOR.$app->name();
            $this->appDumper->dump($app, $appDir);
        }
    }
}
