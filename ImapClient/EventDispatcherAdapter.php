<?php

namespace sergey144010\ImapClient;

class EventDispatcherAdapter implements EventDispatcherInterface
{
    private $dispatcher;

    public function __construct(object $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    };
    public function attach(string $object, string $event, callable $handler){};
    public function trigger(string $name, object $object, $params){};
}
