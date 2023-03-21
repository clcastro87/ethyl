<?php

namespace Ethyl\Filter;

use FilterIterator as BaseFilterIterator;
use Iterator;

/**
 * Filter iterator using a callable.
 */
class FilterIterator extends BaseFilterIterator
{
    /**
     * @var callable
     */
    protected $acceptFn;

    /**
     * Constructor.
     *
     * @param Iterator $iterator
     * @param callable $acceptFn
     */
    public function __construct(Iterator $iterator, callable $acceptFn)
    {
        parent::__construct($iterator);

        $this->acceptFn = $acceptFn;
    }

    /**
     * @inheritDoc
     */
    public function accept(): bool
    {
        $val = $this->getInnerIterator()->current();

        return ($this->acceptFn)($val);
    }
}
