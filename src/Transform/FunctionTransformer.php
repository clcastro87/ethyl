<?php

namespace Ethyl\Transform;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Function transformer
 */
class FunctionTransformer extends ValueTransformer
{
    use CallableAwareTrait;

    /**
     * ExpressionTransformer constructor.
     *
     * @param string $expression
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
        return $this->getCallable()->__invoke($item);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        $parent = parent::jsonSerialize();

        return array_merge($parent, ['callable' => 'function']);
    }
}
