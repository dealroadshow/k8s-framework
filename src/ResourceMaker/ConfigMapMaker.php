<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\ConfigMap;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class ConfigMapMaker extends AbstractResourceMaker
{
    /**
     * @param ManifestInterface|ConfigMapInterface $manifest
     * @param AppInterface                         $app
     *
     * @return ConfigMap
     */
    public function makeResource(ManifestInterface $manifest, AppInterface $app): ConfigMap
    {
        $configMap = new ConfigMap();

        $app->metadataHelper()->configureMeta($manifest, $configMap);
        $manifest->data($configMap->data());
        $manifest->binaryData($configMap->binaryData());

        return $configMap;
    }

    public function supportsClass(): string
    {
        return ConfigMapInterface::class;
    }
}
