<?php

namespace Ethyl\Core\Traits;

/**
 * Callable Aware Trait
 */
trait CallableAwareTrait 
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * Sets the callable function.
     * @param callable $fn
     */
    protected function setCallable(callable $fn)
    {
        $this->callable = $fn;
    }

    /**
     * Gets the callable function.
     * @return callable
     */
    protected function getCallable()
    {
        return $this->callable;
    }
}