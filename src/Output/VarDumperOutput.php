<?php

namespace Ethyl\Output;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class VarDumperOutput
 * @package Ethyl\Output
 */
class VarDumperOutput extends IteratorStage
{
    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            print_r($item);
        }
    }
}