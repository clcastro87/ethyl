<?php

namespace Ethyl\Mapping;

use Ethyl\Transform\ValueTransformer;

/**
 * Class AbstractMapper
 * @package Ethyl\Mapping
 */
abstract class AbstractMapper extends ValueTransformer implements MapperInterface
{
    /**
     * Policy for treating missing fields
     */
    const MAP_IGNORE_MISSING  = 0;
    const MAP_FILL_WITH_NULL  = 1;
    const MAP_FILL_WITH_EMPTY = 2;

    /**
     * Maps policy type to descriptive names.
     */
    const POLICY_NAMES = [
        self::MAP_IGNORE_MISSING  => 'Ignore missing',
        self::MAP_FILL_WITH_NULL  => 'Fill with null',
        self::MAP_FILL_WITH_EMPTY => 'Fill with empty',
    ];

    /**
     * {@inheritDoc}
     */
    public function __invoke($payload)
    {
        return $this->map($payload);
    }

    /**
     * {@inheritDoc}
     */
    public function transform($payload)
    {
        return $this->map($payload);
    }

    /**
     * {@inheritDoc}
     */
    public function debug()
    {
        $className = get_class($this);

        return [
            'mapper' => substr($className, strrpos($className, '\\') + 1),
        ];
    }

    /**
     * Maps an input to an output
     *
     * @param $input
     * @return mixed
     */
    public abstract function map($input);
}