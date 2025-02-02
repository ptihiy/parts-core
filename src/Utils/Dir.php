<?php

namespace Parts\Core\Utils;

use DirectoryIterator;

class Dir
{
    public static function files(string $dir): array
    {
        $files = [];

        foreach(new DirectoryIterator($dir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $files[] = $fileInfo->getPathname();
            }
        }

        return $files;
    }
}