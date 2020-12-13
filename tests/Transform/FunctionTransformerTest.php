<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Transform\FunctionTransformer;
use Ethyl\Transform\TransformerInterface;
use function strtolower;

/**
 * Test for FunctionTransformer
 */
class FunctionTransformerTest extends ValueTransformerTest
{
    /**
     * @inheritDoc
     */
    public function getTransformer(): TransformerInterface
    {
        return new FunctionTransformer(function ($item) { return strtolower($item); });
    }

    /**
     * @inheritDoc
     */
    public function getTestData(): array
    {
        return [
            'Test string'  => ['TesT', 'test'],
            'Test url'     => ['https://www.google.com/', 'https://www.google.com/'],
            'Empty string' => ['', '']
        ];
    }
}