<?php

namespace Dealroadshow\K8S\Framework\Core\Service;

final class IPProtocol
{
    const TCP = 'TCP';
    const UDP = 'UDP';
    const SCTP = 'SCTP';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function tcp(): self
    {
        return new self(self::TCP);
    }

    public static function udp(): self
    {
        return new self(self::UDP);
    }

    public static function sctp(): self
    {
        return new self(self::SCTP);
    }
}
