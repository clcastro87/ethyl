<?php

declare(strict_types=1);

namespace Ethyl\Mapping;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Allows to maps using a function.
 *
 * @package Ethyl\Mapping
 */
class FunctionMapper extends AbstractMapper
{
    use CallableAwareTrait;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * Function mapper constructor with a callable as argument.
     *
     * @param callable $callable
     * @param array $extraArguments
     */
    public function __construct(callable $callable, array $extraArguments)
    {
        $this->callable  = $callable;
        $this->arguments = $extraArguments;
    }

    /**
     * @inheritDoc
     */
    public function map($value)
    {
        return call_user_func_array($this->callable, array_merge([$value], $this->arguments));
    }
}
