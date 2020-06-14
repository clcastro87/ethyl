<?php

namespace Ethyl\Filter;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Runs a filter expression for each item present on the iterator.
 *
 * @package Ethyl\Filter
 */
class FunctionIteratorFilter extends IteratorFilter
{
    use CallableAwareTrait;

    /**
     * FunctionIteratorFilter constructor.
     *
     * @param callable $fn
     */
    public function __construct(callable $fn)
    {
        parent::__construct();

        $this->setCallable($fn);
    }

    /**
     * {@inheritDoc}
     */
    public function satisfy($item)
    {
        return $this->getCallable()($item);
    }
}