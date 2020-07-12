<?php

namespace Ethyl\Output;

use Iterator;

/**
 * Output for debugging purposes, uses print_r for each item. 
 * 
 * @package Ethyl\Output
 */
class DebugOutput extends AbstractOutput
{
    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            print_r($item);
            if (!$this->drain) {
                yield $item;
            }
        }

        yield from [];
    }
}