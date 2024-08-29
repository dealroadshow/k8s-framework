<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Apps\V1\Deployment;
use Dealroadshow\K8S\Api\Apps\V1\DeploymentStrategy;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Deployment\DeploymentInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecProcessor;
use Dealroadshow\K8S\Framework\Core\Deployment\StrategyConfigurator;
use Dealroadshow\K8S\Framework\Event\DeploymentGeneratedEvent;
use Dealroadshow\K8S\Framework\ResourceMaker\Traits\ConfigureSelectorTrait;

class DeploymentMaker extends AbstractResourceMaker
{
    use ConfigureSelectorTrait;

    public function __construct(private readonly PodTemplateSpecProcessor $specProcessor)
    {
    }

    public function makeResource(ManifestInterface|DeploymentInterface $manifest, AppInterface $app): Deployment
    {
        $deployment = new Deployment();

        $this->configureSelector($manifest, $deployment->spec()->selector());
        $this->configureStrategy($manifest, $deployment->spec()->strategy());

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
        $spec->setReplicas($replicas);
        if (null !== $minReadySeconds) {
            $spec->setMinReadySeconds($minReadySeconds);
        }
        if (null !== $progressDeadlineSeconds) {
            $spec->setProgressDeadlineSeconds($progressDeadlineSeconds);
        }
        $manifest->configureDeployment($deployment);

        $this->dispatcher->dispatch(new DeploymentGeneratedEvent($manifest, $deployment, $app), DeploymentGeneratedEvent::NAME);

        return $deployment;
    }

    protected function supportsClass(): string
    {
        return DeploymentInterface::class;
    }

    private function configureStrategy(DeploymentInterface|ManifestInterface $manifest, DeploymentStrategy $strategy): void
    {
        $strategyConfigurator = new StrategyConfigurator($strategy);
        $manifest->strategy($strategyConfigurator);
    }
}
