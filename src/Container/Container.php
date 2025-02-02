<?php

namespace Parts\Core\Container;

use InvalidArgumentException;

class Container implements ContainerInterface
{
    protected $services = [];

    public function set(string $id, mixed $service): void
    {
        $this->services[$id] = $service;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function get(string $id): mixed
    {
        $service = $this->services[$id] ?? null;

        if (is_string($service) && class_exists($service)) {
            return new $service();
        }

        return $service;
    }

    public function call(string $id, string $method, array $arguments = []): mixed
    {
        if (!$this->has($id)) {
            if (is_string($id) && class_exists($id)) {
                $service = new $id();
            } else {
                throw new InvalidArgumentException("Service '$id' not found");
            }
        } else {
            $service = $this->get($id);
        }

        if (!is_object($service)) {
            throw new InvalidArgumentException("Service '$id' is not an object");
        }

        if (!method_exists($service, $method)) {
            throw new InvalidArgumentException("Method '$method' not found on service '$id'");
        }

        return $service->{$method}(...$arguments);
    }
}