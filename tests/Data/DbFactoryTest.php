<?php

namespace Ethyl\Tests\Data;

use Ethyl\Data\DbFactory;
use Ethyl\Tests\AbstractTestCase;
use ReflectionException;

/**
 * DbFactory Test
 *
 * @package Ethyl\Tests\Data
 */
class DbFactoryTest extends AbstractTestCase
{
    /**
     * Tests factory create for SQLite.
     * @throws ReflectionException
     */
    public function testCreateSqlite()
    {
        $factory = new DbFactory();
        $file    = __DIR__ . '/../Resources/Chinook.db';
        $conn    = $factory->create('sqlite:' . $file);

        $this->assertNotEmpty($conn);
        $this->assertNotEmpty($conn->query('SELECT * from Artist'));
    }
}