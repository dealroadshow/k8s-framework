<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Image;

class Image
{
    private string $name;
    private ?string $registryUrl;
    private ?string $tag;
    private ?string $prefix = null;

    private function __construct(string $name, ?string $registryUrl, ?string $tag)
    {
        $name = trim($name, '/');
        if (null !== $registryUrl) {
            $registryUrl = rtrim($registryUrl, '/');
        }

        $this->name = $name;
        $this->registryUrl = $registryUrl;
        $this->tag = $tag;
    }

    public function imageName(): string
    {
        return $this->name;
    }

    public function registryUrl(): ?string
    {
        return $this->registryUrl;
    }

    public function tag(): ?string
    {
        return $this->tag;
    }

    public function fullName(): string
    {
        $fullName = '';
        if (null !== $this->registryUrl) {
            $fullName .= $this->registryUrl.'/';
        }
        if (null !== $this->prefix) {
            $fullName .= $this->prefix.'/';
        }
        $fullName .= $this->name;
        if (null !== $this->tag) {
            $fullName .= ':'.$this->tag;
        }

        return $fullName;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setRegistryUrl(string $registryUrl): self
    {
        $this->registryUrl = $registryUrl;

        return $this;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = trim($prefix, '/');

        return $this;
    }

    public static function fromName(string $name)
    {
        return new self($name, null, null);
    }
}
