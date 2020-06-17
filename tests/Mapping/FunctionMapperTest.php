<?php

namespace Ethyl\Tests\Mapping;

use Ethyl\Mapping\FunctionMapper;

/**
 * FunctionMapper Test
 * @package Ethyl\Tests\Mapping
 */
class FunctionMapperTest extends AbstractMapperTest
{
    /**
     * {@inheritDoc}
     */
    public function getMapper()
    {
        return new FunctionMapper(function ($item, $classNumber) {
            $item['age']   = $item['age'] * 2;
            $item['class'] = $classNumber;
            return $item;
        }, ['classNumber' => 44]);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Person' => [
                [
                    'name' => 'Test',
                    'age' => 2,
                    'size' => 1.80,
                ],
                [
                    'name' => 'Test',
                    'age' => 4,
                    'size' => 1.80,
                    'class' => 44,
                ]
            ]
        ];
    }
}