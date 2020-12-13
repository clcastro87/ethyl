<?php

namespace Ethyl\Output;

use EmptyIterator;
use Iterator;

/**
 * Output for debugging purposes, uses print_r for each item.
 *
 * @package Ethyl\Output
 */
class DebugOutput extends AbstractOutput
{
    /**
     * @inheritDoc
     */
    public function iterate(Iterator $iterator): Iterator
    {
        foreach ($iterator as $item) {
            print_r($item);
        }

        if (!$this->drain) {
            $iterator->rewind();
            return $iterator;
        } else {
            return new EmptyIterator();
        }
    }
}
