<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\Collection\IngressRuleList;
use Dealroadshow\K8S\Data\HTTPIngressPath;
use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Data\IngressRule;
use Dealroadshow\K8S\Framework\App\AppInterface;

class IngressRulesConfigurator
{
    private AppInterface $app;
    private IngressRuleList $rules;

    /**
     * @var IngressRule[]
     */
    private array $hostsMap = [];

    private IngressRule|null $ruleWithoutHost = null;

    public function __construct(AppInterface $app, IngressRuleList $rules)
    {
        $this->app = $app;
        $this->rules = $rules;
    }

    public function addHttpRule(string $path, IngressBackend $backend, string $host = null): void
    {
        $rule = null === $host ? $this->getRuleWithoutHost() : $this->getRuleForHost($host);
        $ingressPath = new HTTPIngressPath($backend);
        $ingressPath->setPath($path);
        $rule->http()->paths()->add($ingressPath);
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
