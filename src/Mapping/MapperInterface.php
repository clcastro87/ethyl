<?php


namespace Ethyl\Mapping;

use Ethyl\Core\DebuggableInterface;

/**
 * Mapper Interface
 * @package Ethyl\Mapping
 */
interface MapperInterface extends DebuggableInterface
{
    /**
     * Maps a value into another.
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
    public function map($payload);
}