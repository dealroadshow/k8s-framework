<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\PersistentVolumeClaim;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\TypedLocalObjectReference;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ResourcesConfigurator;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Persistence\PersistentVolumeClaimInterface;
use Dealroadshow\K8S\Framework\Core\Persistence\PvcResourcesConfigurator;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

/**
 * @method PersistentVolumeClaim make(ManifestInterface $manifest, AppInterface $app)
 */
class PersistentVolumeClaimMaker extends AbstractResourceMaker
{
    public function __construct(private AppRegistry $appRegistry)
    {
    }

    protected function supportsClass(): string
    {
        return PersistentVolumeClaimInterface::class;
    }

    protected function makeResource(ManifestInterface|PersistentVolumeClaimInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $pvc = new PersistentVolumeClaim();
        $spec = $pvc->spec();

        $app->metadataHelper()->configureMeta($manifest, $pvc);
        $this->configureAccessModes($manifest, $pvc);
        $this->configureDataSource($manifest, $pvc);

        $resources = new PvcResourcesConfigurator($spec->resources());
        $manifest->resources($resources);

        $selector = new SelectorConfigurator($spec->selector());
        $manifest->selector($selector);

        $storageClassName = $manifest->storageClassName();
        if (null !== $storageClassName) {
            $spec->setStorageClassName($storageClassName);
        }

        $spec->setVolumeMode($manifest->volumeMode()->toString());

        if ($volumeName = $manifest->volumeName()) {
            $spec->setVolumeName($volumeName);
        }

        return $pvc;
    }

    private function configureAccessModes(PersistentVolumeClaimInterface $manifest, PersistentVolumeClaim $pvc)
    {
        $accessModes = $pvc->spec()->accessModes();
        foreach ($manifest->accessModes() as $mode) {
            $accessModes->add($mode->toString());
        }
    }

    private function configureDataSource(PersistentVolumeClaimInterface $manifest, PersistentVolumeClaim $pvc)
    {
        $manifestReference = $manifest->dataSource();
        if (null !== $manifestReference) {
            $app = $this->appRegistry->get($manifestReference->appAlias());
            $class = new \ReflectionClass($manifestReference->className());
            $name = $app->namesHelper()->byManifestClass($class->getName());
            $kind = $class->getMethod('kind')->invoke(null);

            $dataSource = new TypedLocalObjectReference($kind, $name);
            if ($apiGroup = $manifestReference->apiGroup()) {
                $dataSource->setApiGroup($apiGroup);
            }

            $pvc->spec()->setDataSource($dataSource);
        }
    }
}
