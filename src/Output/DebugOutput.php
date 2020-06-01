<?php

namespace Ethyl\Output;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Output for debugging purposes, uses print_r for each item. 
 * 
 * @package Ethyl\Output
 */
class DebugOutput extends IteratorStage
{
    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            print_r($item);
        }
    }
}