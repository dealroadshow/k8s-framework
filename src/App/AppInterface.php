<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Config\ConfigurableInterface;
use Dealroadshow\K8S\Framework\Core\ManifestFile;
use Dealroadshow\K8S\Framework\Helper\Metadata\MetadataHelperInterface;
use Dealroadshow\K8S\Framework\Helper\Names\NamesHelperInterface;

interface AppInterface extends ConfigurableInterface
{
    public static function name(): string;

    /**
     * @return string The alias with which app was registered in AppRegistry
     */
    public function alias(): string;

    public function addManifestFile(string $fileNameWithoutExtension, APIResourceInterface $resource): void;
    public function metadataHelper(): MetadataHelperInterface;
    public function namesHelper(): NamesHelperInterface;
    public function manifestNamePrefix(): string;
    public function manifestConfig(string $shortName): array;

    /**
     * @return ManifestFile[]
     */
    public function manifestFiles(): iterable;
}
