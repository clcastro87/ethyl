<?php

namespace Ethyl\Filter;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Iterator filter
 *
 * @package Ethyl\Filter
 */
abstract class IteratorFilter extends IteratorStage
{
    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            if ($this->satisfy($item)) {
                yield $item;
            }
        }

        yield from [];
    }

    /**
     * Returns if the item pass the filter condition.
     * @param $value
     */
    public abstract function satisfy($value);
}