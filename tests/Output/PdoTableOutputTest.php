<?php


namespace Ethyl\Tests\Output;

use ArrayIterator;
use EmptyIterator;
use Ethyl\Data\DbFactory;
use Ethyl\Output\PdoTableOutput;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;
use PDOException;
use stdClass;

/**
 * PdoTableOutput Test
 *
 * @package Ethyl\Tests\Output
 */
class PdoTableOutputTest extends AbstractTestCase
{
    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInput()
    {
        list($tmpFilePath, $db) = $this->getTestDb();

        $input = new PdoTableOutput($db, 'test_table', 10);
        $iterator = $this->getTestIterator(1300);
        $input($iterator);

        $this->assertNotEmpty(file_get_contents($tmpFilePath));

        unlink($tmpFilePath);
    }

    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInputNotDrain()
    {
        list($tmpFilePath, $db) = $this->getTestDb();

        $input = new PdoTableOutput($db, 'test_table', 100,
            PdoTableOutput::FLAG_TRANSACTIONAL | PdoTableOutput::FLAG_USE_TEMP, false);
        $iterator = $input($this->getTestIterator());

        $count = iterator_count($iterator);
        $this->assertEquals(2, $count);

        unlink($tmpFilePath);
    }

    /**
     * Tests empty input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayEmptyInput()
    {
        list($tmpFilePath, $db) = $this->getTestDb();

        $input = new PdoTableOutput($db, 'test_table');
        $iterator = $input(new EmptyIterator());

        $count = iterator_count($iterator);
        $this->assertEquals(0, $count);

        unlink($tmpFilePath);
    }

    /**
     * Tests invalid input.
     *
     * @throws InvalidArgumentException
     */
    public function testInvalidInput()
    {
        list($tmpFilePath, $db) = $this->getTestDb();

        try {
            $input = new PdoTableOutput($db, 'test-table');
            $this->expectException(InvalidArgumentException::class);
            $input(new stdClass());
        } finally {
            unlink($tmpFilePath);
        }
    }

    /**
     * Tests missing table.
     *
     * @throws InvalidArgumentException
     */
    public function testMissingTableInput()
    {
        list($tmpFilePath, $db) = $this->getTestDb();

        try {
            $input = new PdoTableOutput($db, 'test-table-missing');
            $this->expectException(PDOException::class);
            $input($this->getTestIterator());
        } finally {
            unlink($tmpFilePath);
        }
    }

    /**
     * Get test iterator.
     *
     * @param int $size
     * @return ArrayIterator
     */
    private function getTestIterator(int $size = 2)
    {
        $items = [];

        for ($i = 1; $i <= $size; $i++) {
            $items[] = [
                'age' => rand(0, 99),
                'name' => 'Test ' . $i,
            ];
        }

        return new ArrayIterator($items);
    }

    /**
     * Returns a file name for a temp csv file.
     *
     * @return array
     */
    private function getTestDb()
    {
        $factory = new DbFactory();
        $file = __DIR__ . '/../Resources/Output.db';
        $temp = '/tmp/Output-' . uniqid() . '.db';
        copy($file, $temp);
        $conn = $factory->create('sqlite:' . $temp);

        return [$temp, $conn];
    }
}