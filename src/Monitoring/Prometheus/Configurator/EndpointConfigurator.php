<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

class EndpointConfigurator
{
    public function __construct(private \ArrayObject $data)
    {
    }

    public function basicAuth(SecretKeyReference $username, SecretKeyReference $password): static
    {
        $this->data['basicAuth'] = [
            'username' => $username,
            'password' => $password,
        ];

        return $this;
    }

    public function bearerTokenSecret(SecretKeyReference $secretRef): static
    {
        $this->data['bearerTokenSecret'] = $secretRef;

        return $this;
    }

    public function bearerTokenFile(string $filename): static
    {
        $this->data['bearerTokenFile'] = $filename;

        return $this;
    }

    public function honorLabels(bool $honorLabels): static
    {
        $this->data['honorLabels'] = $honorLabels;

        return $this;
    }

    public function honorTimestamps(bool $honorTimestamps): static
    {
        $this->data['honorTimestamps'] = $honorTimestamps;

        return $this;
    }

    public function interval(string $interval): static
    {
        $this->data['interval'] = $interval;

        return $this;
    }

    public function metricRelabelings(array $metricRelabelings): static
    {
        $this->data['metricRelabelings'] = $metricRelabelings;

        return $this;
    }

    public function params(array $params): static
    {
        $this->data['params'] = $params;

        return $this;
    }

    public function path(string $path): static
    {
        $this->data['path'] = $path;

        return $this;
    }

    public function port(string $port): static
    {
        $this->data['port'] = $port;

        return $this;
    }

    public function proxyUrl(string $proxyUrl): static
    {
        $this->data['proxyUrl'] = $proxyUrl;

        return $this;
    }

    public function relabelings(array $relabelings): static
    {
        $this->data['relabelings'] = $relabelings;

        return $this;
    }

    public function scheme(string $scheme): static
    {
        $this->data['scheme'] = $scheme;

        return $this;
    }

    public function scrapeTimeout(string $scrapeTimeout): static
    {
        $this->data['scrapeTimeout'] = $scrapeTimeout;

        return $this;
    }

    public function targetPort(int|string $targetPort): static
    {
        $this->data['targetPort'] = $targetPort;

        return $this;
    }

    public function tlsConfig(array $tlsConfig): static
    {
        $this->data['tlsConfig'] = $tlsConfig;

        return $this;
    }
}
