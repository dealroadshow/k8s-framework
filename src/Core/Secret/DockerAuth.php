<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

readonly class DockerAuth
{
    public function __construct(
        public string $host,
        public string $username,
        public string $password,
        public string|null $email = null
    ) {
    }
}
