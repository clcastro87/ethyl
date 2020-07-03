<?php

namespace Ethyl\Input;

use InvalidArgumentException;

/**
 * Xml File Input.
 *
 * @package Ethyl\Input
 */
class XmlFileInput extends XmlStreamInput
{
    /**
     * {@inheritDoc}
     */
    public function __invoke($payload)
    {
        if (is_string($payload)) {
            $iterator = $this->getIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to a string input.');
        }

        return $this->iterate($iterator);
    }
}