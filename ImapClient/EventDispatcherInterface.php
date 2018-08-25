<?php
# this is draft
namespace sergey144010\ImapClient;

interface EventDispatcherInterface
{
    # https://docs.zendframework.com/zend-eventmanager/quick-start/
    public function attach($eventName, callable $listener, $priority = 1);
    public function detach(callable $listener, $eventName = null);
    public function trigger($eventName, $target = null, $argv = []);
}
