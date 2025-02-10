<?php

namespace test;

use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\FileTemplateLoader;
use Parts\Core\TemplateEngine\Directives\ForeachDirective;

final class ForeachDirectiveTest extends TestCase
{
    public function testSimpleIfDirective()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/data');

        $foreachDirective = new ForeachDirective();

        $this->assertEquals(
            '<?php foreach ($users as $user): ?>hello world<?php endforeach; ?>',
            $foreachDirective->employ($loader->load('foreach.simple'))
        );
    }
}