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
     * @param Stage|null $processor
     */
    public function __construct(string $resource, Stage $input, Stage $processor = null)
    {
        parent::__construct($input, $processor);

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