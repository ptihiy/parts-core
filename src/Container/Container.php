<?php

namespace Parts\Core\Container;

use ReflectionClass;
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

        if ($service === null) {
            if (!class_exists($id)) {
                throw new InvalidArgumentException("Service '$id' not found");
            } else {
                return $this->instantiate($id);
            }
        }

        if (is_string($service) && class_exists($service)) {
            $instance = $this->instantiate($service);

            $this->set($id, $instance);

            return $instance;
        }

        return $service;
    }

    protected function instantiate(string $id): mixed
    {
        $reflection = new ReflectionClass($id);
        $constructor = $reflection->getConstructor();

        if ($constructor) {
            $parameters = $constructor->getParameters();

            $args = [];
            foreach ($parameters as $parameter) {
                $type = $parameter->getType();

                if (!$this->has($type->getName())) {
                    throw new InvalidArgumentException("Service '{$type->getName()}' not found");
                } else {
                    $args[] = $this->get($type->getName());
                }
            }

            $instance = new $id(...$args);

            return $instance;
        } else {
            return new $id();
        }
    }

    public function call(string $id, string $method, array $arguments = []): mixed
    {
        $service = $this->get($id); 

        if (!is_object($service)) {
            throw new InvalidArgumentException("Service '$id' is not an object");
        }

        if (!method_exists($service, $method)) {
            throw new InvalidArgumentException("Method '$method' not found on service '$id'");
        }

        return $service->{$method}(...$arguments);
    }
}