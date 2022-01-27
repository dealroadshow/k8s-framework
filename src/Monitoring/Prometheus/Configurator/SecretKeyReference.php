<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

class SecretKeyReference implements \JsonSerializable
{
    private function __construct(private string $name, private string $key, private bool $optional)
    {
    }

    public static function fromSecretNameAndKey(string $secretName, string $secretKey, bool $optional): static
    {
        return new static($secretName, $secretKey, $optional);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'key' => $this->key,
            'optional' => $this->optional,
        ];
    }
}
