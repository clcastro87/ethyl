<?php

declare(strict_types=1);

namespace Ethyl\Transform;

use Ethyl\Core\DebuggableInterface;

/**
 * Transformer chain.
 *
 * @package Ethyl\Transform
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
     * @inheritDoc
     */
    public function transform($value)
    {
        $result = $value;

        foreach ($this->transformers as $transformer) {
            $result = $transformer->transform($result);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        $debugInfo = parent::debug();
        $chain = array_map(function ($item) {
            /**
             * @var DebuggableInterface $item
             */
            return $item->debug();
        }, $this->transformers);

        $debugInfo['chain'] = $chain;

        return $debugInfo;
    }
}

