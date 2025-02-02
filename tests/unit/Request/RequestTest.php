<?php

namespace test;

use Parts\Core\Request\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testRequestCanBeCreated()
    {
        $request = new Request();
        $this->assertInstanceOf(Request::class, $request);
    }

    public function testRequestCanReturnHttpMethod()
    {
        $request = new Request();
        $this->assertEquals('GET', $request->getMethod());
    }

    public function testRequestCanReturnUrl()
    {
        $request = new Request();
        $this->assertEquals('/', $request->getUrl());
    }
}