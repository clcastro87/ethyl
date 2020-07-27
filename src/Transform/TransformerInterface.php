<?php

namespace Ethyl\Transform;

use Ethyl\Core\DebuggableInterface;

/**
 * Transformer Interface.
 *
 * @package Ethyl\Transform
 */
interface TransformerInterface extends DebuggableInterface
{
    /**
     * Applies a transformation to a value.
     *
     * @param $value
     * @return bool
     */
    public function __invoke($value);

    /**
     * Transform the payload.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function transform($payload);
}
