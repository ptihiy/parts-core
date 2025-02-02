<?php

namespace test;

use Parts\Core\Kernel;
use Parts\Core\Request\Request;
use PHPUnit\Framework\TestCase;

final class KernelTest extends TestCase
{
    public function testKernelReturnsText()
    {
        $kernel = new Kernel(new Request());
        $this->assertEquals('success', $kernel->start());
    }
}