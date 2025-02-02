<?php

namespace Parts\Core\Utils;

use ReflectionClass;

class Reflection
{
    public static function usesTrait(object|string $objectOrClass, string $trait): bool
    {
        $traits = [];

        do {
            $traits = array_merge(class_uses($objectOrClass), $traits);
        } while ($objectOrClass = get_parent_class($objectOrClass));

        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch));
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait), $traits);
        }

        return in_array($trait, array_unique($traits));
    }
}