<?php

namespace Ethyl\Tests\Core;

use Ethyl\Core\Stage;
use Ethyl\Tests\AbstractTestCase;

/**
 * Test for Stage.
 */
class StageTest extends AbstractTestCase
{
    /**
     * Test the invoke method.
     */
    public function testInvoke()
    {
        $stage = $this->getMockForAbstractClass(Stage::class);
        $stage->method('__invoke')->willReturn(true);
        
        $this->assertTrue($stage(null));
    }
}
