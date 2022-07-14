<?php

declare(strict_types=1);

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
        $this->callable = $fn;
    }

    /**
     * @inheritDoc
     */
    public function transform($value)
    {
        return call_user_func($this->callable, $value);
    }

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        $parent = parent::debug();

        return array_merge($parent, ['callable' => 'function']);
    }
}

