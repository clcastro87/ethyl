<?php


namespace Ethyl\Flow;


use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class BatchDisAggregator
 * @package Ethyl\Flow
 */
class BatchDisAggregator extends IteratorStage
{
    /**
     * {@inheritDoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $batch)
        {
            yield from $batch;
        }
    }
}