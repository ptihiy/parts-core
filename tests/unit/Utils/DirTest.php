<?php

namespace test;

use Parts\Core\Utils\Dir;
use PHPUnit\Framework\TestCase;

final class DirTest extends TestCase
{
    public function testDirCanListFiles(): void
    {
        $files = Dir::files(__DIR__ . '/data');

        $this->assertIsArray($files);
        $this->assertNotEmpty($files);
    }
}