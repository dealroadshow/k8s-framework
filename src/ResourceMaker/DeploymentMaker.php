<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Apps\Deployment;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Deployment\DeploymentInterface;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecProcessor;

class DeploymentMaker extends AbstractResourceMaker
{
    private PodTemplateSpecProcessor $specProcessor;

    public function __construct(PodTemplateSpecProcessor $specProcessor)
    {
        $this->specProcessor = $specProcessor;
    }

    public function makeResource(ManifestInterface|DeploymentInterface $manifest, AppInterface $app): Deployment
    {
        $deployment = new Deployment();

        $specSelector = $deployment->spec()->selector();
        $selector = new SelectorConfigurator($specSelector);
        $manifest->selector($selector);

        if (0 === $specSelector->matchLabels()->count() && 0 === $specSelector->matchExpressions()->count()) {
            throw new \LogicException(
                sprintf(
                    'Manifest class "%s" does not provide selector labels or expressions. Please implement method "%s"::selector()',
                    $manifest::class,
                    $manifest::class,
                )
            );
        }

        $app->metadataHelper()->configureMeta($manifest, $deployment);
        $this->specProcessor->process($manifest, $deployment->spec()->template(), $app);

        $spec = $deployment->spec();
        foreach ($spec->selector()->matchLabels()->all() as $name => $value) {
            $deployment->metadata()->labels()->add($name, $value);
            $deployment->spec()->template()->metadata()->labels()->add($name, $value);
        }

        $replicas = $manifest->replicas();
        $minReadySeconds = $manifest->minReadySeconds();
        $progressDeadlineSeconds = $manifest->progressDeadlineSeconds();
        if (null !== $replicas) {
            $spec->setReplicas($replicas);
        }
        if (null !== $minReadySeconds) {
            $spec->setMinReadySeconds($minReadySeconds);
        }
        if (null !== $progressDeadlineSeconds) {
            $spec->setProgressDeadlineSeconds($progressDeadlineSeconds);
        }
        $manifest->configureDeployment($deployment);

        return $deployment;
    }

    protected function supportsClass(): string
    {
        return DeploymentInterface::class;
    }
}
