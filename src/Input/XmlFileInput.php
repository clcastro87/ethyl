<?php

namespace Ethyl\Input;

use InvalidArgumentException;
use Iterator;

/**
 * Xml File Input
 */
class XmlFileInput extends XmlStreamInput
{
    /**
     * @{inheritdoc}
     *
     * @param $payload
     * @return Iterator
     * @throws InvalidArgumentException
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