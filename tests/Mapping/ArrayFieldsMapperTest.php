<?php

namespace Ethyl\Tests\Mapping;

use Ethyl\Mapping\ArrayFieldsMapper;
use Ethyl\Mapping\MapperInterface;
use InvalidArgumentException;

/**
 * ArrayFieldsMapper Test
 *
 * @package Ethyl\Tests\Mapping
 */
class ArrayFieldsMapperTest extends AbstractMapperTest
{
    /**
     * @inheritDoc
     */
    protected function getMapper(): MapperInterface
    {
        return new ArrayFieldsMapper([
                                         'id'      => 'id',
                                         'name'    => 'title',
                                         'missing' => 'missed',
                                     ]);
    }

    /**
     * @inheritDoc
     */
    public function getTestData(): array
    {
        return [
            'Main' => [
                [
                    'id'   => 1,
                    'name' => 'lola',
                    'age'  => 10,
                ],
                [
                    'id'     => 1,
                    'title'  => 'lola',
                    'missed' => '',
                ],
            ]
        ];
    }

    /**
     * Test reverse mapping.
     */
    public function getReverseMapper(): MapperInterface
    {
        return new ArrayFieldsMapper([
                                         'id'      => 'id',
                                         'name'    => 'title',
                                         'missing' => 'missed',
                                     ], ArrayFieldsMapper::MAP_FILL_WITH_NULL, true);
    }

    /**
     * Test reverse map feature.
     *
     * @dataProvider getReverseTestData
     * @param $input
     * @param $result
     */
    public function testReverseMap($input, $result)
    {
        $mapper = $this->getReverseMapper();
        $output = $mapper->map($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Get test data for reverse mapping.
     */
    public function getReverseTestData(): array
    {
        return [
            'Main' => [
                [
                    'id'    => 1,
                    'title' => 'lola',
                    'age'   => 10,
                ],
                [
                    'id'      => 1,
                    'name'    => 'lola',
                    'missing' => '',
                ],
            ]
        ];
    }

    /**
     * Test wrong input.
     */
    public function testWrongInput()
    {
        $mapper = $this->getMapper();
        $this->expectException(InvalidArgumentException::class);
        $mapper->map(null);
    }

    /**
     * Test empty input.
     */
    public function testEmptyInput()
    {
        $mapper = $this->getMapper();
        $output = $mapper->map([]);

        $this->assertEquals([], $output);
    }

    /**
     * Test ignore missing.
     *
     * @dataProvider getTestMissingData
     *
     * @param $input
     * @param $result
     */
    public function testIgnoreMissing($input, $result)
    {
        $mapper = new ArrayFieldsMapper([
                                            'id'      => 'id',
                                            'name'    => 'title',
                                            'missing' => 'missed',
                                        ], ArrayFieldsMapper::MAP_IGNORE_MISSING);
        $output = $mapper->map($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Get test data for missing fields.
     */
    public function getTestMissingData(): array
    {
        return [
            'Main' => [
                [
                    'id'   => 1,
                    'name' => 'lola',
                    'age'  => 10,
                ],
                [
                    'id'    => 1,
                    'title' => 'lola',
                ],
            ]
        ];
    }
}
