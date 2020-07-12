<?php

namespace Ethyl\Output;

use Ethyl\Core\IteratorStage;

/**
 * Abstract iterator output.
 *
 * @package Ethyl\Output
 */
abstract class AbstractOutput extends IteratorStage
{
    /**
     * If the value is going to be discarded or sent to another stage.
     *
     * @var bool
     */
    protected $drain;

    /**
     * DebugOutput constructor.
     *
     * @param bool $drain
     */
    public function __construct($drain = true)
    {
        parent::__construct();

        $this->drain = $drain;
    }
}