<?php

declare(strict_types=1);

namespace Ethyl\Core;

/**
 * Interface DebuggableInterface
 *
 * @package Ethyl\Core
 */
interface DebuggableInterface
{
    /**
     * Returns an associative array with debug information.
     *
     * @return array
     */
    public function debug(): array;
}
