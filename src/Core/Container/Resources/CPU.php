<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Resources;

use LogicException;

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

    public function greaterThan(CPU $cpu): bool
    {
        return $this->millicoresNumber() > $cpu->millicoresNumber();
    }

    public function lowerThan(CPU $cpu): bool
    {
        return $this->millicoresNumber() < $cpu->millicoresNumber();
    }

    public function equals(CPU $cpu): bool
    {
        return $this->millicoresNumber() === $cpu->millicoresNumber();
    }

    public function millicoresNumber(): int
    {
        if (str_ends_with($this->value, self::MILLICORES_SUFFIX)) {
            return (int)rtrim($this->value, self::MILLICORES_SUFFIX);
        } elseif (is_numeric($this->value)) {
            return (int)$this->value * 1000;
        }

        throw new LogicException(
            sprintf(
                'Invalid value format for CPU: "%s"',
                $this->value
            )
        );
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
            return static::cores((int)$string);
        }

        $exception = new \InvalidArgumentException(
            sprintf('Invalid CPU string "%s"', $string)
        );
        if (str_ends_with($string, self::MILLICORES_SUFFIX)) {
            $millicoresNumber = rtrim($string, self::MILLICORES_SUFFIX);
            if (!is_numeric($millicoresNumber)) {
                throw $exception;
            }

            return self::millicores((int)$millicoresNumber);
        }

        throw $exception;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
