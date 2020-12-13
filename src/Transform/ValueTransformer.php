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
     * @inheritDoc
     */
    public function __invoke($value)
    {
        return $this->transform($value);
    }

    /**
     * @inheritDoc
     */
    public abstract function transform($value);

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        return [
            'transform' => $this->getClassName(),
        ];
    }
}
