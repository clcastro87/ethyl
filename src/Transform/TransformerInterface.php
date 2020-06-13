<?php


namespace Ethyl\Transform;

use Ethyl\Core\DebuggableInterface;

/**
 * Transformer Interface
 * @package Ethyl\Transform
 */
interface TransformerInterface extends DebuggableInterface
{
    /**
     * Returns if the item pass the filter condition.
     * @param $value
     * @return bool
     */
    public function __invoke($value);

    /**
     * Transform the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function transform($payload);
}