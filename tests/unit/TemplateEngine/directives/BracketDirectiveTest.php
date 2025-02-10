<?php

namespace test;

use PHPUnit\Framework\TestCase;
use Parts\Core\TemplateEngine\FileTemplateLoader;
use Parts\Core\TemplateEngine\Directives\BracketDirective;

final class BracketDirectiveTest extends TestCase
{
    public function testIncludesDirective()
    {
        $loader = new FileTemplateLoader();
        $loader->setTemplatesBaseDir(__DIR__ . '/../data');

        $includesDirective = new BracketDirective();

        $this->assertEquals(
            '<?= $hello ?>',
            $includesDirective->employ("{{ hello }}")
        );
    }
}