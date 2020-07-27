<?php

namespace Ethyl\Core\Traits;

/**
 * Debuggable Trait.
 *
 * @package Ethyl\Core\Traits
 */
trait DebuggableTrait
{
    /**
     * Returns an associative array with debug information.
     *
     * @return array
     */
    public function debug()
    {
        return [
            'class' => $this->getClassName(),
        ];
    }

    /**
     * Returns the class name.
     *
     * @return string
     */
    protected function getClassName()
    {
        $className = get_class($this);

        return substr($className, strrpos($className, '\\') + 1);
    }
}
