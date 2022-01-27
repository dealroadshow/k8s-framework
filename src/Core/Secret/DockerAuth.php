<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

class DockerAuth
{
    public function __construct(public readonly string $host, public readonly string $username, public readonly string $password, public readonly string|null $email = null)
    {
    }
}
