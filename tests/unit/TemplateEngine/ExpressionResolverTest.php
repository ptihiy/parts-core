<?php

namespace test;

use Parts\Core\TemplateEngine\ExpressionResolver;
use PHPUnit\Framework\TestCase;

class  ExpressionResolverTest extends TestCase
{
    public function testExpressionResolverCanResolveSingleVariable()
    {
        $er = new ExpressionResolver('foo');
        $this->assertEquals('$foo', $er->phpize());
    }

    public function testExpressionResolverCanResolveArrayItem()
    {
        $er = new ExpressionResolver('foo.bar');
        $this->assertEquals("\$foo['bar']", $er->phpize());
    }
}