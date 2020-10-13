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

    public function __construct(AppInterface $app, IngressRuleList $rules)
    {
        $this->app = $app;
        $this->rules = $rules;
    }

    public function addHttpRule(string $path, IngressBackend $backend, string $host = null): void
    {
        $ingressPath = new HTTPIngressPath($backend);
        $ingressPath->setPath($path);

        $rule = new IngressRule();
        if (null !== $host) {
            $rule->setHost($host);
        }
        $rule->http()->paths()->add($ingressPath);
        $this->rules->add($rule);
    }
}
