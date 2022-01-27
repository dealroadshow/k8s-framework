<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\Collection\IngressRuleList;
use Dealroadshow\K8S\Data\IngressRule;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

class IngressRulesConfigurator
{
    /**
     * @var IngressRule[]
     */
    private array $hostsMap = [];

    private IngressRule|null $ruleWithoutHost = null;

    public function __construct(
        private IngressRuleList $rules,
        private AppInterface $app,
        private ManifestReferenceUtil $manifestReferenceUtil
    ) {
    }

    public function addHttpRule(string $host = null): IngressRuleConfigurator
    {
        $rule = null === $host ? $this->getRuleWithoutHost() : $this->getRuleForHost($host);

        return new IngressRuleConfigurator(
            rule: $rule,
            app: $this->app,
            manifestReferenceUtil: $this->manifestReferenceUtil
        );
    }

    private function getRuleForHost(string $host): IngressRule
    {
        if (!array_key_exists($host, $this->hostsMap)) {
            $this->hostsMap[$host] = new IngressRule();
            $this->hostsMap[$host]->setHost($host);
            $this->rules->add($this->hostsMap[$host]);
        }

        return $this->hostsMap[$host];
    }

    private function getRuleWithoutHost(): IngressRule
    {
        if (null === $this->ruleWithoutHost) {
            $this->ruleWithoutHost = new IngressRule();
            $this->rules->add($this->ruleWithoutHost);
        }

        return $this->ruleWithoutHost;
    }
}
