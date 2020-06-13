<?php


namespace Ethyl\Core\Traits;

/**
 * Trait DebuggableTrait
 * @package Ethyl\Core\Traits
 */
trait DebuggableTrait
{
    public function debug()
    {
        $className = get_class($this);

        return [
            'transformer' => substr($className, strrpos($className, '\\') + 1),
        ];
    }
}