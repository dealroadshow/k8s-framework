<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\ImagePullSecrets;

use Dealroadshow\K8S\Api\Core\V1\LocalObjectReference;
use Dealroadshow\K8S\Api\Core\V1\LocalObjectReferenceList;
use Dealroadshow\K8S\Framework\App\AppInterface;

class ImagePullSecretsConfigurator
{
    private LocalObjectReferenceList $secrets;
    private AppInterface $app;

    public function __construct(LocalObjectReferenceList $secrets, AppInterface $app)
    {
        $this->secrets = $secrets;
        $this->app = $app;
    }

    public function addSecretByClassName(string $secretClassName): self
    {
        $secretName = $this->app->namesHelper()->bySecretClass($secretClassName);

        return $this->addSecretByName($secretName);
    }

    public function addSecretByName(string $secretName): self
    {
        $ref = new LocalObjectReference();
        $ref->setName($secretName);
        $this->secrets->add($ref);

        return $this;
    }
}
