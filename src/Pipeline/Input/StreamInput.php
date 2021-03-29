<?php


namespace Ethyl\Pipeline\Input;


use Ethyl\Core\Stage;
use Ethyl\Pipeline\Input;
use Iterator;

class StreamInput extends Input
{
    /**
     * @var string
     */
    protected $resource;

    /**
     * StreamInput constructor.
     *
     * @param resource $resource
     * @param Stage $input
     */
    public function __construct($resource, Stage $input)
    {
        parent::__construct($input);

        $this->resource = $resource;
    }

    /**
     * @inheritDoc
     */
    public function extract($payload = null): Iterator
    {
        return parent::extract($this->resource);
    }
}