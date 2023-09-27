<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker\Prometheus;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\RuleGroupsConfigurator;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\PrometheusRuleApiResource;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\PrometheusRuleInterface;
use Dealroadshow\K8S\Framework\ResourceMaker\AbstractResourceMaker;

class PrometheusRuleMaker extends AbstractResourceMaker
{
    protected function supportsClass(): string
    {
        return PrometheusRuleInterface::class;
    }

    protected function makeResource(ManifestInterface|PrometheusRuleInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $data = new \ArrayObject();
        $data['apiVersion'] = $manifest::apiVersion();
        $data['kind'] = $manifest::kind();

        $data['metadata'] = new ObjectMeta();
        $prometheusRule = new PrometheusRuleApiResource($data);
        $app->metadataHelper()->configureMeta($manifest, $prometheusRule);

        $data['spec'] = new \ArrayObject();
        $data['spec']['groups'] = new \ArrayObject();

        $groupsConfigurator = new RuleGroupsConfigurator($data['spec']['groups']);
        $manifest->groups($groupsConfigurator);

        return $prometheusRule;
    }
}
