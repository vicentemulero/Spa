<?php declare(strict_types=1);

namespace App\Shared\Domain;

use ReflectionClass;

final class ClassUtils
{
    public static function extractClassName(object $object): string
    {
        return (new ReflectionClass($object))->getShortName();
    }
}
