<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\ServiceAccount\Configurator;

use Dealroadshow\K8S\Data\Collection\LocalObjectReferenceList;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

readonly class ImagePullSecretsConfigurator
{
    public function __construct(
        private ManifestReferenceUtil $manifestReferenceUtil,
        private LocalObjectReferenceList $secrets
    ) {
    }

    public function add(ManifestReference $secretReference): static
    {
        $secretClass = $secretReference->className();
        if (!is_subclass_of($secretClass, SecretInterface::class, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'ImagePullSecretsConfigurator accepts references to secrets, but class "%s" in provided reference does not implement SecretInterface',
                    $secretClass
                )
            );
        }

        $localObjectReference = $this->manifestReferenceUtil->toLocalObjectReference($secretReference);
        $this->secrets->add($localObjectReference);

        return $this;
    }
}
