<?php

declare(strict_types=1);

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
     * @return mixed
     */
    public function __invoke($value);

    /**
     * Transform the value.
     *
     * @param mixed $value
     * @return mixed
     */
    public function transform($value);
}
