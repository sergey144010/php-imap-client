<?php

namespace sergey144010\ImapClient;

class EventDispatcherAdapter implements EventDispatcherInterface
{
    private $dispatcher;

    public function __construct(object $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    };
    
    public function attach($eventName, callable $listener, $priority = 1){};
    public function detach(callable $listener, $eventName = null){};
    public function trigger($eventName, $target = null, $argv = []){};
}
