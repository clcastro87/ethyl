<?php

namespace Ethyl\Tests\Core;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class to test the default iteration of IteratorStage
 *
 * @package Ethyl\Tests\Core
 */
class DefaultIteratorStage extends IteratorStage
{
    /**
     * Exposes the default iteration.
     *
     * @param Iterator $iterator
     * @return Iterator
     */
    public function iterate(Iterator $iterator): Iterator
    {
        return parent::iterate($iterator);
    }
}
