<?php

namespace Ethyl\Transform;

use Ethyl\Core\Traits\DebuggableTrait;

/**
 * Class ValueTransformer
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
}
