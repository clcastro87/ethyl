<?php

declare(strict_types=1);

namespace Ethyl\Input;

use Ethyl\Core\IteratorStage;
use Ethyl\Helper\IteratorTools;
use InvalidArgumentException;
use Iterator;

/**
 * Iterates over the items on an array.
 *
 * @package Ethyl\Input
 */
class ArrayInput extends IteratorStage
{
    /**
     * @inheritDoc
     */
    public function __invoke($payload): Iterator
    {
        if (is_array($payload)) {
            return IteratorTools::convertToIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to array objects.');
        }
    }
}
