<?php

declare(strict_types=1);

namespace Ethyl\Filter;

use Ethyl\Core\DebuggableInterface;

/**
 * Filter interface.
 *
 * @package Ethyl\Filter
 */
interface FilterInterface extends DebuggableInterface
{
    /**
     * Returns if the item pass the filter condition.
     *
     * @param $value
     * @return bool
     */
    public function __invoke($value): bool;

    /**
     * Returns if the item pass the filter condition.
     *
     * @param $value
     * @return bool
     */
    public function accept($value): bool;
}
