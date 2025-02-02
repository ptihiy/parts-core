<?php

namespace test;

use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\TemplateEngine;
use Parts\Core\TemplateEngine\TemplateLoaderInterface;

final class TemplateEngineTest extends TestCase
{
    public function testTemplateEngineCanRenderInlineTemplate(): void
    {
        $templateEngine = new TemplateEngine(new class  implements TemplateLoaderInterface { 
            public function load(string $id): string { return ''; }
        });

        $this->assertEquals('hello world', $templateEngine->renderInline('hello world'));
    }

    public function testTemplateEngineCanRenderInlineTemplateWithSimpleVariable(): void
    {
        $templateEngine = new TemplateEngine(new class  implements TemplateLoaderInterface { 
            public function load(string $id): string { return ''; }
        });

        $this->assertEquals('hello world', $templateEngine->renderInline('hello {{ name }}', ['name' => 'world']));
    }

    public function testTemplateEngineCanRenderLoadedTemplate(): void
    {
        $templateEngine = new TemplateEngine(new class implements TemplateLoaderInterface {
            public function load(string $template): string
            {
                return 'hello {{ name }}';
            }
        });

        $this->assertEquals('hello world', $templateEngine->render('index', ['name' => 'world']));
    }
}