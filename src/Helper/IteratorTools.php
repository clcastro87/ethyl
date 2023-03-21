<?php

namespace Ethyl\Helper;

use Exception;
use Iterator;

final class IteratorTools
{
    /**
     * Converts an iterable into an iterator.
     *
     * @param iterable $iterable
     * @return Iterator
     * @throws Exception
     */
    public static function convertToIterator(iterable $iterable): Iterator
    {
        if (is_array($iterable)) {
            if (empty($iterable)) {
                $iterable = new \EmptyIterator();
            } else {
                $iterable = new \ArrayIterator($iterable);
            }

            return $iterable;
        }

        if ($iterable instanceof \IteratorAggregate) {
            $iterable = $iterable->getIterator();
        }

        if (!$iterable instanceof \Iterator) {
            $iterable = new \IteratorIterator($iterable);
        }

        return $iterable;
    }
}
