<?php

namespace test;

use Parts\Core\TemplateEngine\Directives\ExtendsDirective;
use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\FileTemplateLoader;

final class ExtendsDirectiveTest extends TestCase
{
    public function testExtendsDirective()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/../data');

        $extendsDirective = new ExtendsDirective($loader);

        $this->assertEquals(
            'hello world',
            $extendsDirective->employ($loader->load('layout-extender'))
        );
    }
}