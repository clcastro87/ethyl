<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Transform\FunctionTransformer;
use Ethyl\Transform\TransformerChain;
use function sha1;
use function strtolower;

/**
 * Test for TransformerChain
 */
class TransformerChainTest extends ValueTransformerTest
{
    /**
     * {@inheritDoc}
     */
    public function getTransformer()
    {
        $toLower = new FunctionTransformer(function ($item) { return strtolower($item); });
        $sha1    = new FunctionTransformer(function ($item) { return sha1($item); });

        return new TransformerChain([$toLower, $sha1]);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Test string' => ['TesT', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'],
            'Test url'    => ['https://www.google.com/', '595c3cce2409a55c13076f1bac5edee529fc2e58'],
        ];
    }
}