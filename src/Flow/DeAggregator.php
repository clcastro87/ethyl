<?php

declare(strict_types=1);

namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use InvalidArgumentException;
use Iterator;

/**
 * De-aggregates an iterator of arrays, flattening those to first level.
 *
 * @package Ethyl\Flow
 */
class DeAggregator extends IteratorStage
{
    /**
     * @inheritDoc
     */
    public function iterate(Iterator $iterator): Iterator
    {
        foreach ($iterator as $batch) {
            if (!is_iterable($batch)) {
                throw new InvalidArgumentException('Each batch must be iterable.');
            }

            foreach ($batch as $item) {
                yield $item;
            }
        }

        yield from [];
    }
}
