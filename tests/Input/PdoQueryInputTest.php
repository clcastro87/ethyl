<?php

namespace Ethyl\Tests\Input;

use Ethyl\Data\Db;
use Ethyl\Data\DbFactory;
use Ethyl\Data\Query;
use Ethyl\Input\PdoQueryInput;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;

/**
 * PdoQueryInput Test
 *
 * @package Ethyl\Tests\Input
 */
class PdoQueryInputTest extends AbstractTestCase
{
    /**
     * Test with a string query.
     */
    public function testQueryAsString()
    {
        $query  = 'SELECT * from Artist';
        $input  = $this->getPdoInput();
        $output = $input($query);
        $arr    = iterator_to_array($output);
        $this->assertNotEmpty($arr);
    }

    /**
     * Test with Query instance.
     */
    public function testQuery()
    {
        $query  = 'SELECT * from Artist WHERE ArtistId = :id';
        $input  = $this->getPdoInput();
        $output = $input(new Query($query, ['id' => 1]));
        $arr    = iterator_to_array($output);
        $this->assertNotEmpty($arr);
    }

    /**
     * Test with wrong input.
     */
    public function testWrongInput()
    {
        $query = 'SELECT * from Artist WHERE ArtistId = :id';
        $input = $this->getPdoInput();
        $this->expectException(InvalidArgumentException::class);
        $input(array($query, ['id' => 1]));
    }

    /**
     * Gets the PdoInput
     *
     * @return PdoQueryInput
     */
    private function getPdoInput(): PdoQueryInput
    {
        $db = $this->getConnection();
        return new PdoQueryInput($db);
    }

    /**
     * Get connection.
     *
     * @return Db
     */
    private function getConnection(): Db
    {
        $factory = new DbFactory();
        $file    = __DIR__ . '/../Resources/Chinook.db';
        return $factory->create('sqlite:' . $file);
    }
}