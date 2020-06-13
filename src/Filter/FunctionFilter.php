<?php

namespace Ethyl\Filter;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Runs a filter expression for each item present on the iterator.
 *
 * @package Ethyl\Filter
 */
class FunctionFilter extends IteratorFilter
{
    use CallableAwareTrait;

    /**
     * FunctionFilter constructor.
     *
     * @param callable $fn
     */
    public function __construct(callable $fn)
    {
        $this->setCallable($fn);
    }

    /**
     * {@inheritDoc}
     */
    public function satisfy($item)
    {
        return $this->getCallable()->__invoke($item);
    }
}