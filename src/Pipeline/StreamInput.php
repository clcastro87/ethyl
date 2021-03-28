<?php


namespace Ethyl\Pipeline;


use Ethyl\Core\Stage;
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
     * @param string $resource
     * @param Stage $input
     */
    public function __construct(string $resource, Stage $input)
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