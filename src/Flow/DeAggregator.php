<?php

namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * De-aggregates an iterator of arrays, flattening those to first level.
 *
 * @package Ethyl\Flow
 */
class DeAggregator extends IteratorStage
{
    /**
     * {@inheritDoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $batch) {
            foreach ($batch as $item) {
                yield $item;
            }
        }
    }
}
