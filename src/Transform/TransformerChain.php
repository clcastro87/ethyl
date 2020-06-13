<?php

namespace Ethyl\Transform;

use JsonSerializable;

/**
 * Transformer chain
 */
class TransformerChain extends ValueTransformer
{
    /**
     * @var array
     */
    protected $transformers;

    /**
     * TransformerChain constructor.
     *
     * @param ValueTransformer[] $transformers
     */
    public function __construct(array $transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * {@inheritDoc}
     */
    public function transform($input)
    {
        $result = $input;

        foreach ($this->transformers as $transformer) {
            $result = $transformer->transform($result);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        $parent = parent::jsonSerialize();
        $chain = array_map(function ($item) {
            /**
             * @var JsonSerializable $item
             */
            return $item->jsonSerialize();
        }, $this->transformers);

        return array_merge($parent, ['chain' => $chain]);
    }
}
