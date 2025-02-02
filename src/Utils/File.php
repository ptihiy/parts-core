<?php

namespace Parts\Core\Utils;

class File
{
    public static function exists(string $file): bool
    {
        return file_exists($file);
    }

    public static function get(string $file): string
    {
        return file_get_contents($file);
    }
}