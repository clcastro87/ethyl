<?php

declare(strict_types=1);

namespace Ethyl\Filter;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Runs a filter function over a value and returns if satisfies the condition to be fulfilled.
 *
 * @package Ethyl\Filter
 */
class FunctionFilter extends ValueFilter
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
     * @inheritDoc
     */
    public function satisfy($value): bool
    {
        return $this->getCallable()($value);
    }
}
