<?php

namespace test;

use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\FileTemplateLoader;
use Parts\Core\TemplateEngine\Directives\IfDirective;
use Parts\Core\TemplateEngine\Directives\ExtendsDirective;

final class IfDirectiveTest extends TestCase
{
    public function testSimpleIfDirective()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/data');

        $ifDirective = new IfDirective();

        $this->assertEquals(
            '<?php if (true): ?>hello world<?php endif; ?>',
            $ifDirective->employ($loader->load('if.simple'))
        );
    }

    public function testCompleteIfDirective()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/data');

        $ifDirective = new IfDirective();

        $this->assertEquals(
            '<?php if (true): ?>hello world<?php else: ?>bye world<?php endif; ?>',
            $ifDirective->employ($loader->load('if.full'))
        );
    }
}