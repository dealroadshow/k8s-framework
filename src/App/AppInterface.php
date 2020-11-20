<?php

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Config\ConfigurableInterface;
use Dealroadshow\K8S\Framework\Core\ManifestFile;
use Dealroadshow\K8S\Framework\Helper\Metadata\MetadataHelperInterface;
use Dealroadshow\K8S\Framework\Helper\Names\NamesHelperInterface;
use Dealroadshow\K8S\Framework\Project\ProjectInterface;

interface AppInterface extends ConfigurableInterface
{
    public function addManifestFile(string $fileNameWithoutExtension, APIResourceInterface $resource): void;
    public function metadataHelper(): MetadataHelperInterface;
    public function name(): string;
    public function namesHelper(): NamesHelperInterface;
    public function setProject(ProjectInterface $project): void;
    public function project(): ProjectInterface;

    /**
     * @return ManifestFile[]|iterable
     */
    public function manifestFiles(): iterable;
}
