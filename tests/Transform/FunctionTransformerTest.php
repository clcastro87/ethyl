<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Transform\FunctionTransformer;
use function strtolower;

/**
 * Test for FunctionTransformer
 */
class FunctionTransformerTest extends ValueTransformerTest
{
    /**
     * {@inheritDoc}
     */
    public function getTransformer()
    {
        return new FunctionTransformer(function ($item) { return strtolower($item); });
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Test string'  => ['TesT', 'test'],
            'Test url'     => ['https://www.google.com/', 'https://www.google.com/'],
            'Empty string' => ['', '']
        ];
    }
}