<?php

namespace Ethyl\Tests\Data;

use Ethyl\Data\Query;
use Ethyl\Tests\AbstractTestCase;

/**
 * Parametrized query test.
 *
 * @package Ethyl\Tests\Data
 */
class QueryTest extends AbstractTestCase
{
    /**
     * Test create query.
     */
    public function testCreate()
    {
        $instance = new Query('SELECT * FROM city;');
        $this->assertInstanceOf(Query::class, $instance);
        $this->assertNotEmpty($instance->getStatement());
        $this->assertEmpty($instance->getParameters());
    }

    /**
     * Test parameters.
     */
    public function testParameters()
    {
        $instance = new Query('SELECT * FROM city WHERE name = :name;', ['name' => 'Montreal']);
        $this->assertInstanceOf(Query::class, $instance);
        $this->assertNotEmpty($instance->getStatement());
        $this->assertNotEmpty($instance->getParameters());
        $this->assertArrayHasKey('name', $instance->getParameters());
    }

    /**
     * Test parameters.
     */
    public function testSetProps()
    {
        $instance = new Query('SELECT * FROM city WHERE name = :name;', ['name' => 'Montreal']);
        $this->assertInstanceOf(Query::class, $instance);
        $this->assertNotEmpty($instance->getStatement());
        $this->assertNotEmpty($instance->getParameters());
        $this->assertArrayHasKey('name', $instance->getParameters());
    }
}