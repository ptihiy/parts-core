<?php

namespace test;

use stdClass;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Parts\Core\Container\Container;

final class ContainerTest extends TestCase
{
    public function testContainerCanBeCreated()
    {
        $container = new Container();
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testContainerImplementsHasMethod()
    {
        $container = new Container();
        $container->set('foo', 'bar');
        $this->assertTrue($container->has('foo'));
    }

    public function testContainerCanGetService()
    {
        $container = new Container();
        $container->set('foo', 'bar');
        $this->assertEquals('bar', $container->get('foo'));
    }

    public function testContainerCanHoldScalarValue()
    {
        $container = new Container();
        $container->set('foo', 'bar');
        $this->assertEquals('bar', $container->get('foo'));
    }

    public function testContainerCanHoldObject()
    {
        $container = new Container();
        $container->set('foo', new stdClass());
        $this->assertInstanceOf(stdClass::class, $container->get('foo'));
    }

    public function testContainerCanInstantiateClass()
    {
        $container = new Container();
        $container->set('foo', stdClass::class);
        $this->assertInstanceOf(stdClass::class, $container->get('foo'));
    }

    public function testContainerCanCallObjectMethod()
    {
        $container = new Container();
        $container->set('foo', new class extends stdClass {
            public function bar()
            {
                return 'bar';
            }
        });
        $this->assertEquals('bar', $container->call('foo', 'bar'));
    }

    public function testContainerThrowsExceptionTryingToCallMethodOnNonExistingId()
    {
        $container = new Container();
        $container->set('foo', new stdClass());
        $this->expectException(InvalidArgumentException::class);
        $container->call('boo', 'bar');
    }

    public function testContainerThrowsExceptionTryingToCallMethodOnNonObject()
    {
        $container = new Container();
        $container->set('foo', 42);
        $this->expectException(InvalidArgumentException::class);
        $container->call('foo', 'bar');
    }

    public function testContainerThrowsExceptionTryingToCallNonExistingMethod()
    {
        $container = new Container();
        $container->set('foo', new stdClass());
        $this->expectException(InvalidArgumentException::class);
        $container->call('foo', 'bar');
    }
}