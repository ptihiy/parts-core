<?php

namespace test;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\FileTemplateLoader;
use RuntimeException;

final class FileTemplateLoaderTest extends TestCase
{
    public function testFileTemplateLoaderThrowsExceptionWhenBaseDirNotSet(): void
    {
        $loader = new FileTemplateLoader();
        $this->expectException(InvalidArgumentException::class);
        $loader->load('non-existent-template');
    }
    public function testFileTemplateLoaderThrowsExceptionWhenTemplateNotFound(): void
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/data');
        $this->expectException(InvalidArgumentException::class);
        $loader->load('non-existent-template');
    }

    public function testFileTemplateLoaderCanLoadTemplate(): void
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/data');
        $this->assertEquals('hello {{ name }}', $loader->load('index'));
    }
}