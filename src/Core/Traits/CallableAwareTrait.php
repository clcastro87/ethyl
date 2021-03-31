<?php

declare(strict_types=1);

namespace Ethyl\Core\Traits;

/**
 * Callable Aware Trait.
 *
 * @package Ethyl\Core\Traits
 */
trait CallableAwareTrait
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * Sets the callable function.
     *
     * @param callable $fn
     */
    protected function setCallable(callable $fn)
    {
        $this->callable = $fn;
    }

    /**
     * Gets the callable function.
     *
     * @return callable
     */
    protected function getCallable(): callable
    {
        return $this->callable;
    }
}
