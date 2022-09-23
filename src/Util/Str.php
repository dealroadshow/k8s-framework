<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

class Str
{
    public static function asClassName(string $str): string
    {
        $str = ucwords($str, " \t\r\n\f\v-_");

        return preg_replace('/[\s\-_]+/', '', $str);
    }

    public static function camelCased(string $str): string
    {
        return lcfirst(static::asClassName($str));
    }

    public static function withoutSuffix(string $str, string $suffix): string
    {
        return str_ends_with($str, $suffix)
            ? substr($str, 0, -strlen($suffix))
            : $str;
    }

    public static function withSuffix(string $className, string $suffix): string
    {
        return static::withoutSuffix($className, $suffix).$suffix;
    }

    public static function asDirName(string $str, string $suffix = null): string
    {
        $className = self::asClassName($str);

        return $suffix ? self::withoutSuffix($className, $suffix) : $className;
    }

    public static function asNamespace(object $object): string
    {
        $reflection = new \ReflectionObject($object);
        $namespace = $reflection->getNamespaceName();

        return trim($namespace, '\\');
    }

    public static function asDir(object $object): string
    {
        $reflection = new \ReflectionObject($object);

        return dirname($reflection->getFileName());
    }

    public static function asDNSSubdomain(string $str): string
    {
        $str = self::camelCased($str);
        $dashed = self::camelCasedToSeparatedWords($str, '-');
        $valid = preg_replace('/([^\w\-]|[_])+/', '', $dashed);

        if (0 === strlen($valid)) {
            throw new \InvalidArgumentException(
                sprintf('String "%s" cannot be converted DNS subdomain representation', $str)
            );
        }
        if (253 < strlen($valid)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'String "%s" DNS subdomain representation is too long (must be less than 253 characters)',
                    $str
                )
            );
        }

        return $valid;
    }

    public static function underscored(string $str): string
    {
        $str = self::camelCased($str);

        return self::camelCasedToSeparatedWords($str, '_');
    }

    public static function isValidDNSSubdomain(string $str): bool
    {
        if (false === filter_var($str, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return false;
        }

        return !str_contains($str, '.');
    }

    public static function stringify(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string)$value;
    }

    private static function camelCasedToSeparatedWords(string $camelCased, string $separator): string
    {
        return strtolower(
            preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1'.$separator, $camelCased)
        );
    }
}
