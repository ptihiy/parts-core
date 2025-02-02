<?php

namespace test;

use Parts\Core\Utils\File;
use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    public function testFileUtilCanCheckIfFileExists(): void
    {
        $this->assertTrue(File::exists(__FILE__));
        $this->assertFalse(File::exists('non-existent-file'));
    }

    public function testFileUtilCanGetFileContents(): void
    {
        $this->assertEquals(file_get_contents(__FILE__), File::get(__FILE__));
    }
}