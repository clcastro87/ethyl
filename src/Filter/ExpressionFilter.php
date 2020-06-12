<?php

namespace Ethyl\Filter;

use Iterator;
use function create_function;

/**
 * Runs a filter expression for each item present on the iterator.
 * 
 * @package Ethyl\Filter
 */
class ExpressionFilter extends IteratorFilter
{
    /**
     * fn to run for each item.
     *
     * @var callable
     */
    protected $fn;

    /**
     * ExpressionFilter constructor.
     *
     * @param string $expression
     */
    public function __construct(string $expression)
    {
        $this->fn = create_function('$item', $expression);
    }

    /**
     * {@inheritDoc}
     */
    public function satisfy($item)
    {
        return $this->fn->__invoke($item);
    }
}