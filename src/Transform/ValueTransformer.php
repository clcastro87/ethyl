<?php

declare(strict_types=1);

namespace Ethyl\Transform;

use Ethyl\Helper\Reflection;

/**
 * Value Transformer.
 *
 * @package Ethyl\Transform
 */
abstract class ValueTransformer implements TransformerInterface
{
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
    abstract public function transform($value);

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        return [
            'transform' => Reflection::getClassName(static::class),
        ];
    }
}
