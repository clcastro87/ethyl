<?php

namespace Ethyl\Core;

interface DebuggableInterface
{
    /**
     * Returns an associative array with debug information.
     *
     * @return array
     */
    public function debug();
}