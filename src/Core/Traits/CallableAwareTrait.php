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
     */
    protected function setCallable(callable $fn)
    {
        $this->callable = $fn;
    }

    /**
     * Gets the callable function.
     */
    protected function getCallable()
    {
        return $this->callable;
    }
}