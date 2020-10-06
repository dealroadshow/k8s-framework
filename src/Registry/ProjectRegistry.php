<?php

namespace Dealroadshow\K8S\Framework\Registry;

use LogicException;
use Dealroadshow\K8S\Framework\Project\ProjectInterface;

class ProjectRegistry
{
    /**
     * @var array<string, ProjectInterface>|ProjectInterface[]
     */
    private array $projects;

    /**
     * @param iterable|ProjectInterface[] $projects
     */
    public function __construct(iterable $projects)
    {
        $this->projects = [];
        foreach ($projects as $project) {
            $name = $project->name();
            if (!$this->has($name)) {
                $this->projects[$name] = $project;

                continue;
            }
            throw new LogicException(
                sprintf(
                    'Project name must be unique, but "%s" and "%s" share the same name "%s"',
                    get_class($this->projects[$name]),
                    get_class($project),
                    $name
                )
            );
        }
    }

    /**
     * @return array|ProjectInterface[]
     */
    public function all(): array
    {
        return array_values($this->projects);
    }

    public function has(string $projectName): bool
    {
        return array_key_exists($projectName, $this->projects);
    }

    public function get(string $projectName): ProjectInterface
    {
        return $this->projects[$projectName];
    }
}
