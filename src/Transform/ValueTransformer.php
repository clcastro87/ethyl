<?php

namespace Ethyl\Transform;

use JsonSerializable;

/**
 * Abstract Transform
 */
abstract class ValueTransformer implements JsonSerializable
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function __invoke($payload)
    {
        return $this->transform($payload);
    }

    /**
     * Transform the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public abstract function transform($payload);

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        $className = get_class($this);

        return [
            'transformer' => substr($className, strrpos($className, '\\') + 1),
        ];
    }
}
