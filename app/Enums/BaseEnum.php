<?php

namespace App\Enums;

use ReflectionClass;

abstract class BaseEnum
{
    public static function getConstants(): array
    {
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
