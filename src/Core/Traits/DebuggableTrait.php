<?php

declare(strict_types=1);

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
    public function debug(): array
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
    protected function getClassName(): string
    {
        $className = get_class($this);

        return substr($className, strrpos($className, '\\') + 1);
    }
}
