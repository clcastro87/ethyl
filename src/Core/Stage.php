<?php

namespace Ethyl\Core;

use Ethyl\Event\EventAggregator;
use Ethyl\Event\StageInitializedEvent;
use JsonSerializable;
use League\Pipeline\StageInterface;

/**
 * Abstract stage who works with iterators/generators.
 * 
 * @package Ethyl\Core
 */
abstract class Stage implements StageInterface, JsonSerializable, DebuggableInterface
{
    /**
     * Stage name.
     *
     * @var string
     */
    protected $stageName;

    /**
     * Identifier for the stage.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Stage constructor.
     */
    public function __construct()
    {
        $this->stageName  = $this->getStageName();
        $this->identifier = uniqid();

        $this->fireEvent(StageInitializedEvent::class);
    }

    /**
     * Returns the stage name.
     *
     * @return string
     */
    protected function getStageName()
    {   
        $className = get_class($this);
     
        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * Returns event scope.
     *
     * @return string
     */
    protected function getStageScope()
    {
        return sprintf("event.stage.%s.%s", strtolower($this->stageName), $this->identifier);
    }

    /**
     * Fires a local event.
     *
     * @param string $eventClass
     * @param [mixed] ...$args
     * @return void
     */
    protected function fireEvent(string $eventClass, ...$args)
    {
        $event = new $eventClass(...$args);
        if (method_exists($event, 'setScope')) {
            $event->setScope($this->getStageScope());
        }

        EventAggregator::getInstance()->emit($event);
    }

    /**
     * Fires an event.
     *
     * @param string $eventClass
     * @param [mixed] ...$args
     * @return void
     */
    protected function fireGlobalEvent(string $eventClass, ...$args)
    {
        $event = new $eventClass(...$args);

        EventAggregator::getInstance()->emit($event);
    }

    /**
     * {@inheritDoc}
     */
    public function debug()
    {
        return [
            'stage'       => $this->stageName,
            'identifier'  => $this->identifier,
            'event_scope' => $this->getStageScope(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return [
            'stage' => $this->stageName,
        ];
    }
}