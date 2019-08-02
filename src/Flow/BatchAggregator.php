<?php


namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class BatchAggregator
 * @package Ethyl\Flow
 */
class BatchAggregator extends IteratorStage
{
    /**
     * @var int
     */
    protected $batchSize;

    /**
     * BatchAggregator constructor.
     * @param int $batchSize
     */
    public function __construct(int $batchSize)
    {
        $this->batchSize = $batchSize;
    }

    /**
     * {@inheritDoc}
     */
    public function iterate(Iterator $iterator)
    {
        $batch = [];
        $count = 0;
        foreach ($iterator as $item)
        {
            $batch[] = $item;
            if (++$count == $this->batchSize) {
                yield $batch;
                $batch = [];
                $count = 0;
            }
        }
        yield $batch;
    }
}