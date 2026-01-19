<?php

namespace Ethyl\Tests\Core;

use Ethyl\Core\FunctionStage;
use Ethyl\Tests\AbstractTestCase;
use stdClass;

/**
 * Test for FunctionStage.
 */
class FunctionStageTest extends AbstractTestCase
{
    /**
     * Test the invoke method.
     */
    public function testInvoke()
    {
        $func = function ($payload) {
            $payload->processed = true;
            return $payload;
        };

        $stage = new FunctionStage($func);
        $payload = new stdClass();
        $payload->processed = false;

        $result = $stage($payload);

        $this->assertTrue($result->processed);
    }
}
