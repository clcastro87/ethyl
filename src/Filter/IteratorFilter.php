<?php

namespace Ethyl\Filter;

use Ethyl\Core\IteratorStage;
use Ethyl\Core\Traits\DebuggableTrait;
use Iterator;

/**
 * Iterator filter.
 *
 * @package Ethyl\Filter
 */
abstract class IteratorFilter extends IteratorStage implements FilterInterface
{
    use DebuggableTrait;

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
     * {@inheritDoc}
     */
    public abstract function satisfy($value);
}
