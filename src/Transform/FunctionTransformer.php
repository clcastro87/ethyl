<?php

namespace Ethyl\Transform;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Function transformer.
 *
 * @package Ethyl\Transform
 */
class FunctionTransformer extends ValueTransformer
{
    use CallableAwareTrait;

    /**
     * ExpressionTransformer constructor.
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
    public function transform($item)
    {
        return $this->getCallable()($item);
    }

    /**
     * {@inheritDoc}
     */
    public function debug()
    {
        $parent = parent::debug();

        return array_merge($parent, ['callable' => 'function']);
    }
}
