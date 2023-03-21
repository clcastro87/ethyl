<?php

namespace Ethyl\Helper;

/**
 * Reflection helper.
 */
final class Reflection
{
    /**
     * Gets the classname.
     *
     * @param string $className
     * @return string
     */
    public static function getClassName(string $className): string
    {
        return substr($className, strrpos($className, '\\') + 1);
    }
}
