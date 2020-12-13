<?php

namespace Ethyl\Tests\Data;

use Ethyl\Data\Db;
use Ethyl\Data\DbFactory;
use Ethyl\Tests\AbstractTestCase;

/**
 * Db Test
 *
 * @package Ethyl\Tests\Data
 */
class DbTest extends AbstractTestCase
{
    /**
     * Test query function.
     */
    public function testQuery()
    {
        $conn = $this->getDb();
        $this->assertNotEmpty($conn);
        $this->assertNotEmpty($conn->query('SELECT * from Artist WHERE ArtistId = :id', ['id' => 3]));
    }

    /**
     * Tests get result (generator).
     */
    public function testGetResult()
    {
        $conn = $this->getDb();
        $this->assertNotEmpty($conn);
        $iterator = $conn->getResult('SELECT * from Artist WHERE ArtistId = :id', ['id' => 3]);
        $count    = iterator_count($iterator);
        $this->assertEquals(1, $count);
    }

    /**
     * Tests get empty result (generator).
     */
    public function testGetResultEmpty()
    {
        $conn = $this->getDb();
        $this->assertNotEmpty($conn);
        $iterator = $conn->getResult('SELECT * from Artist WHERE ArtistId = :id', ['id' => 0]);
        $count    = iterator_count($iterator);
        $this->assertEquals(0, $count);
    }

    /**
     * Tests execute.
     */
    public function testExecute()
    {
        $conn = $this->getDb();
        $this->assertNotEmpty($conn);
        $result = $conn->execute('INSERT INTO Artist (Name) VALUES (:name)', ['name' => 'test']);
        $this->assertEquals(true, $result);
        $result = $conn->execute('DELETE FROM Artist WHERE Name = :name', ['name' => 'test']);
        $this->assertEquals(true, $result);
    }

    /**
     * Gets the db instance.
     *
     * @return Db
     */
    protected function getDb(): Db
    {
        $db         = (new DbFactory())->create('sqlite::memory:');
        $operations = [
            '
                CREATE TABLE "Artist" (
                    "ArtistId"	INTEGER NOT NULL,
                    "Name"	NVARCHAR(120),
                    CONSTRAINT "PK_Artist" PRIMARY KEY("ArtistId")
                );
            ',
            'INSERT INTO "Artist" VALUES (1, "Test 1");',
            'INSERT INTO "Artist" VALUES (2, "Test 2");',
            'INSERT INTO "Artist" VALUES (3, "Test 3");',
        ];
        foreach ($operations as $op) {
            $db->execute($op);
        }

        return $db;
    }
}