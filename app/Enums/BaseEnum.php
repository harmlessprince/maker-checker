<?php

namespace App\Enums;

use ReflectionClass;

abstract class BaseEnum
{
    public static function getConstants()
    {
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
