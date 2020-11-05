<?php

namespace Dealroadshow\K8S\Framework\Helper\Names;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Helper\HelperInterface;

interface NamesHelperInterface extends HelperInterface
{
    public function fullName(string $shortName): string;
    public function byManifestClass(string $manifestClass): string;
    public function byConfigMapClass(string $configMapClass): string;
    public function bySecretClass(string $configMapClass): string;
    public function byServiceClass(string $serviceClass): string;
}
