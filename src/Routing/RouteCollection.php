<?php

namespace Parts\Core\Routing;

class RouteCollection
{
    protected array $routes = [];

    public function addRoute(string $method, string $path, mixed $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'action' => $action
        ];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function merge(RouteCollection $routeCollection): void
    {
        $this->routes = array_merge($this->routes, $routeCollection->getRoutes());
    }

    public function filter(array $methods, ?string $path = null): array
    {
        if (empty($methods)) {
            $methods = ['GET', 'POST', 'PUT', 'DELETE'];
        }

        return array_filter($this->routes, function ($route) use ($methods, $path) {
            return in_array($route['method'], $methods) && ($path === null || $route['path'] === $path);
        });
    }
}