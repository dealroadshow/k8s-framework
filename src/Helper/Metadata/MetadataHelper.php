<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Helper\Metadata;

use Dealroadshow\K8S\Apimachinery\Pkg\Apis\Meta\V1\ObjectMeta;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\DynamicNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\MetadataAwareInterface;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;
use Dealroadshow\K8S\Framework\Core\Service\DeploymentAwareServiceInterface;
use Dealroadshow\K8S\Framework\Helper\Names\NamesHelperInterface;
use Dealroadshow\K8S\Framework\Util\ManifestShortName;

class MetadataHelper implements MetadataHelperInterface
{
    private NamesHelperInterface $namesHelper;

    public function configureMeta(MetadataAwareInterface $metadataAware, APIResourceInterface $apiObject): ObjectMeta
    {
        $meta = $apiObject->metadata();
        $metaConfigurator = new MetadataConfigurator($meta->labels(), $meta->annotations());
        $metadataAware->metadata($metaConfigurator);

        if ($metadataAware instanceof ManifestInterface) {
            $shortName = ManifestShortName::getFrom($metadataAware);

            if ($metadataAware instanceof DeploymentAwareServiceInterface) {
                $deploymentClass = $metadataAware::deploymentClass();
                if (is_subclass_of($deploymentClass, DynamicNameAwareInterface::class)) {
                    throw new \LogicException(
                        sprintf(
                            'Instances of class "%s" are named dynamically (see "%s"), therefore service name cannot be derived from deployment class. Please implement `ServiceInterface` instead of `DeploymentAwareServiceInterface` in your service class.',
                            $deploymentClass,
                            DynamicNameAwareInterface::class
                        )
                    );
                }
                $shortName = $deploymentClass::shortName();
            }

            $name = $this->namesHelper->fullName($shortName);
            $meta->setName($name);
        }

        return $meta;
    }

    public function setNamesHelper(NamesHelperInterface $namesHelper): void
    {
        $this->namesHelper = $namesHelper;
    }
}
