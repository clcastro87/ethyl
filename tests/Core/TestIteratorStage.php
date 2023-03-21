<?php

namespace Ethyl\Tests\Core;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class to test features of IteratorStage
 *
 * @package Ethyl\Tests\Core
 */
class TestIteratorStage extends IteratorStage
{
    /**
     * Test iteration.
     *
     * @param Iterator $iterator
     * @return Iterator
     */
    public function iterate(Iterator $iterator): Iterator
    {
        foreach ($iterator as $item) {
            yield $item;
        }
    }
}
