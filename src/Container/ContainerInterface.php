<?php

namespace Parts\Core\Container;

interface ContainerInterface
{
    public function set(string $id, mixed $service);

    public function has(string $id): bool;

    public function get(string $id): mixed;

    public function call(string $id, string $method, array $arguments = []): mixed;
}