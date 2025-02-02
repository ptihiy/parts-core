<?php

namespace test;

use PHPUnit\Framework\TestCase;
use Parts\Core\Routing\RouteCollection;

class RouteCollectionTest extends TestCase
{
    public function testEmptyCollectionReturnsZeroRoutes(): void
    {
        $routeCollection = new RouteCollection();

        $routes = $routeCollection->getRoutes();

        $this->assertIsArray($routes);
        $this->assertEmpty($routes);
    }

    public function testAddRouteMethod(): void
    {
        $routeCollection = new RouteCollection();        
        $routeCollection->addRoute('GET', '/', ['/users', 'UserController@index']);

        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }
    
    public function testCollectionsCanBeMerged(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute('GET', '/', ['/users', 'UserController@index']);

        $routeCollection2 = new RouteCollection();
        $routeCollection2->addRoute('GET', '/show', ['/users', 'UserController@show']);

        $routeCollection->merge($routeCollection2);

        $this->assertEquals(2, count($routeCollection->getRoutes()));
    }

    public function testRoutesCanBeFiltered(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute('GET', '/', ['/users', 'UserController@index']);
        $routeCollection->addRoute('POST', '/show', ['/users', 'UserController@show']);  

        $this->assertEquals(2, count($routeCollection->getRoutes()));
        $this->assertEquals(1, count($routeCollection->filter(['GET'])));
        $this->assertEquals(1, count($routeCollection->filter([], '/show')));
    }
}