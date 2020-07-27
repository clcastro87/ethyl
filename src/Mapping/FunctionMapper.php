<?php

namespace Ethyl\Mapping;

use Closure;
use stdClass;

/**
 * Allows to maps using a function.
 *
 * @package Ethyl\Mapping
 */
class FunctionMapper extends AbstractMapper
{
    /**
     * @var Closure
     */
    protected $closure;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * Function mapper constructor with a callable as argument.
     *
     * @param callable $closure
     * @param array $extraArguments
     */
    public function __construct(callable $closure, array $extraArguments)
    {
        $this->closure   = Closure::bind($closure, new stdClass());
        $this->arguments = $extraArguments;
    }

    /**
     * {@inheritDoc}
     */
    public function map($input)
    {
        return call_user_func_array($this->closure, array_merge([$input], $this->arguments));
    }
}
