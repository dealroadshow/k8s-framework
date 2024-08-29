<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Collection\StringMap;

abstract class AbstractBasicAuthSecret extends AbstractSecret
{
    abstract protected function username(): string;
    abstract protected function password(): string;

    final public function data(StringMap $data): void
    {
        $data->addAll([
            'username' => $this->username(),
            'password' => $this->password(),
        ]);
    }

    final public function stringData(StringMap $stringData): void
    {
    }

    final public function type(): SecretType
    {
        return SecretType::BasicAuth;
    }
}
