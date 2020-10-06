<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Policy;

class RestartPolicy
{
    private const ALWAYS = 'Always';
    private const ON_FAILURE = 'OnFailure';
    private const NEVER = 'Never';

    private string $policy;

    private function __construct(string $policy)
    {
        $this->policy = $policy;
    }

    public function toString(): string
    {
        return $this->policy;
    }

    public static function always(): self
    {
        return new self(self::ALWAYS);
    }

    public static function onFailure(): self
    {
        return new self(self::ON_FAILURE);
    }

    public static function never(): self
    {
        return new self(self::NEVER);
    }
}
