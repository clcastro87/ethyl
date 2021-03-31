<?php

declare(strict_types=1);

namespace Ethyl\Mapping;

use Ethyl\Core\DebuggableInterface;

/**
 * Mapper Interface.
 *
 * @package Ethyl\Mapping
 */
interface MapperInterface extends DebuggableInterface
{
    /**
     * Maps a value into another.
     *
     * @param mixed $value
     * @return mixed
     */
    public function __invoke($value);

    /**
     * Map a value into another.
     *
     * @param mixed $value
     * @return mixed
     */
    public function map($value);
}
