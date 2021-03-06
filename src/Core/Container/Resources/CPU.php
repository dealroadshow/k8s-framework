<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

class CPU implements \JsonSerializable
{
    private const MILLICORES_SUFFIX = 'm';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function millicores(int $millicoresNumber): self
    {
        $value = strval($millicoresNumber).self::MILLICORES_SUFFIX;

        return new self($value);
    }

    public static function cores(int $coresNumber): self
    {
        return new self(strval($coresNumber));
    }

    public static function fromString(string $string): self
    {
        if (is_numeric($string)) {
            return static::cores($string);
        }

        $exception = new \InvalidArgumentException(
            sprintf('Invalid CPU string "%s"', $string)
        );
        if (str_ends_with($string, self::MILLICORES_SUFFIX)) {
            $millicoresNumber = rtrim($string, self::MILLICORES_SUFFIX);
            if (!is_numeric($millicoresNumber)) {
                throw $exception;
            }

            return self::millicores($millicoresNumber);
        }

        throw $exception;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
