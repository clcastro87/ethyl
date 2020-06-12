<?php

namespace Ethyl\Filter;

use Closure;

/**
 * Runs a filter closure for each item present on the iterator.
 * 
 * @package Ethyl\Filter
 */
class ClosureFilter extends IteratorFilter
{
    /**
     * fn to run for each item.
     *
     * @var Closure
     */
    protected $closure;

    /**
     * ClosureFilter constructor.
     *
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * {@inheritDoc}
     */
    public function satisfy($item)
    {
        return $this->closure->__invoke($item);
    }
}