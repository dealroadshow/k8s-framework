<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\Collection\IngressRuleList;
use Dealroadshow\K8S\Data\HTTPIngressPath;
use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Data\IngressRule;
use Dealroadshow\K8S\Framework\Core\Ingress\IngressRule\PathType;

// @TODO needs refactoring along with future changes in IngressBackendFactory (it's refactoring to IngressBackendConfigurator)
class IngressRulesConfigurator
{
    /**
     * @var IngressRule[]
     */
    private array $hostsMap = [];

    private IngressRule|null $ruleWithoutHost = null;

    public function __construct(private IngressRuleList $rules)
    {
    }

    public function addHttpRule(string|null $path, IngressBackend|null $backend, string $host = null, PathType $pathType = null): static
    {
        $rule = null === $host ? $this->getRuleWithoutHost() : $this->getRuleForHost($host);
        $pathType = $pathType ?? PathType::prefix();
        $ingressPath = new HTTPIngressPath($pathType->toString());
        $rule->http()->paths()->add($ingressPath);

        if ($path) {
            $ingressPath->setPath($path);
        }
        if ($backend) {
            if ($serviceBackend = $backend->getService()) {
                $ingressPath->backend()->setService($serviceBackend);
            } elseif ($resourceBackend = $backend->getResource()) {
                $ingressPath->backend()->setResource($resourceBackend);
            }
        }

        return $this;
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
