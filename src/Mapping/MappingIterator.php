<?php

namespace Ethyl\Mapping;

use Ethyl\Core\Traits\CallableAwareTrait;
use IteratorIterator;
use Traversable;

/**
 * Iterator that maps values from another iterator.
 */
class MappingIterator extends IteratorIterator
{
    use CallableAwareTrait;

    /**
     * Constructor.
     *
     * @param Traversable $iterator
     * @param callable $callable
     */
    public function __construct(Traversable $iterator, callable $callable)
    {
        parent::__construct($iterator);

        $this->callable = $callable;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        if (!$this->valid()) {
            return parent::current();
        } else {
            return call_user_func($this->callable, parent::current());
        }
    }
}