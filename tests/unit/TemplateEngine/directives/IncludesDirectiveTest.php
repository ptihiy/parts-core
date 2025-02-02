<?php

namespace test;

use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\FileTemplateLoader;
use Parts\Core\TemplateEngine\Directives\IncludeDirective;

final class IncludesDirectiveTest extends TestCase
{
    public function testIncludesDirective()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/../data');

        $includesDirective = new IncludeDirective($loader);

        $this->assertEquals(
            'hello world',
            $includesDirective->employ($loader->load('template-with-include'))
        );
    }

    public function testIncludesDirectiveHandlesInnerIncludes()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/data/includes');

        $includesDirective = new IncludeDirective($loader);

        $this->assertEquals(
            'hello world hello',
            $includesDirective->employ($loader->load('template-with-inner-include'))
        );
    }
}