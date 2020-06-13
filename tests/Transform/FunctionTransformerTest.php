<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Tests\AbstractTestCase;
use Ethyl\Transform\FunctionTransformer;
use function strtolower;

class FunctionTransformerTest extends AbstractTestCase
{
    public function testTransform()
    {
        $input = 'TesT';
        $expected = 'test';
        $transform = new FunctionTransformer(function ($item) { return strtolower($item); });
        $output = $transform->transform($input);

        $this->assertEquals($expected, $output);
    }
}