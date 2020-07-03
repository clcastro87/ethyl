<?php

namespace Ethyl\Transform;

use Ethyl\Core\Traits\DebuggableTrait;

/**
 * Value Transformer.
 *
 * @package Ethyl\Transform
 */
abstract class ValueTransformer implements TransformerInterface
{
    use DebuggableTrait;

    /**
     * {@inheritDoc}
     */
    public function __invoke($payload)
    {
        return $this->transform($payload);
    }

    /**
     * {@inheritDoc}
     */
    public abstract function transform($payload);

    /**
     * {@inheritDoc}
     */
    public function debug()
    {
        return [
            'transform' => $this->getClassName(),
        ];
    }
}
