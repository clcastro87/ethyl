<?php

namespace Ethyl\Input;

use EmptyIterator;
use Iterator;
use Prewk\XmlStringStreamer;

/**
 * Xml Stream Input
 */
class XmlStreamInput extends StreamInput
{
    /**
     * @var string
     */
    protected $itemTag;

    /**
     * @var bool
     */
    protected $cleanNamespaces;

    /**
     * XmlStreamInput constructor.
     *
     * @param string $itemTag
     * @param bool   $cleanNamespaces
     */
    public function __construct(string $itemTag = 'item', bool $cleanNamespaces = true)
    {
        parent::__construct();

        $this->itemTag         = $itemTag;
        $this->cleanNamespaces = $cleanNamespaces;
    }

    /**
     * Returns an iterator for accessing to the stream input
     *
     * @param $payload
     * @return Iterator
     */
    public function getIterator($payload)
    {
        $options = [
            'uniqueNode' => $this->itemTag,
        ];

        $streamer = XmlStringStreamer::createUniqueNodeParser($payload, $options);
        // Iterate through the `<item>` nodes
        while ($node = $streamer->getNode()) {
            if ($this->cleanNamespaces) {
                $node = $this->applyNamespaceCleanup($node);
            }
            $node = @simplexml_load_string($node, null, LIBXML_NOCDATA | LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            $node = json_decode(json_encode($node), true);
            if (!empty($node)) {
                yield $node;
            }
        }

        yield from [];
    }

    /**
     * Removes all namespaces existing in node names
     *
     * @param string $nodeStr
     * @return string|string[]|null
     */
    protected function applyNamespaceCleanup(string $nodeStr)
    {
        return preg_replace('/<(\/?)([A-Za-z0-9]+:)(.*?>)/m', '<$1$3', $nodeStr);
    }
}