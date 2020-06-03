<?php

namespace Ethyl\Event;

use League\Event\Emitter;

/**
 * Event aggregator
 */
final class EventAggregator extends Emitter
{
    /**
     * Singleton instance
     *
     * @var self
     */
    private static $instance = null;

    /**
     * Returns the singleton instance.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }
}